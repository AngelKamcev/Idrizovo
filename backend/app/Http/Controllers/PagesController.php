<?php

namespace App\Http\Controllers;

use App\Models\Inmate;
use App\Models\TimeSlot;
use App\Models\VisitCompanion;
use App\Models\Complaint;
use App\Models\VisitRequest;
use App\Models\VisitSchedule;
use App\Models\Announcement;
use App\Models\Activity;
use App\Models\GalleryImage;
use App\Models\Handcraft;
use App\Models\VisitConfirmation;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\IzrabotkiPageController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PagesController extends Controller
{
    /**
     * Show the index page
     */
    public function index()
    {
        $locale = app()->getLocale();

        $activities = Cache::remember('home_activities_' . $locale, 600, function () use ($locale) {
            return Activity::active()->sorted()->take(10)->get()
                ->map(fn($a) => [
                    'name'        => $a->getTranslation('title', $locale),
                    'description' => $a->getTranslation('description', $locale),
                    'image'       => $a->getImageUrl() ?? asset('images/bla.jpeg'),
                ]);
        });

        $announcements = Cache::remember('home_announcements', 300, fn() =>
            Announcement::active()->published()->sorted()->take(12)->get()
        );

        $izrabotki = Cache::remember('izrabotki_page_data_' . $locale, 3600, fn() =>
            app(IzrabotkiPageController::class)->publicData()
        );
        $izrabotkiSections = collect($izrabotki['sections'] ?? []);

        $aboutData = Cache::remember('about_page_data', 3600, fn() =>
            app(AboutUsController::class)->currentData()
        );
        $homeSectors = collect($aboutData['sectors'] ?? [])->take(3);

        $galleryImages = Cache::remember('home_gallery', 600, fn() =>
            GalleryImage::active()->sorted()->take(4)->get()
        );

        return view('index', [
            'activities'        => $activities,
            'announcements'     => $announcements,
            'izrabotkiSections' => $izrabotkiSections,
            'homeSectors'       => $homeSectors,
            'galleryImages'     => $galleryImages,
        ]);
    }

    /**
     * Show the about us page
     */
    public function aboutus()
    {
        $aboutData = Cache::remember('about_page_data', 3600, fn() =>
            app(AboutUsController::class)->currentData()
        );

        return view('aboutus', compact('aboutData'));
    }

    /**
     * Show the activities page
     */
    public function activities()
    {
        $activities = Cache::remember('all_activities', 600, fn() =>
            \App\Models\Activity::active()->sorted()->take(50)->get()
        );
        return view('activities', ['activities' => $activities]);
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        $visitSchedules = Cache::remember('visit_schedules_active', 3600, fn() =>
            VisitSchedule::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
        );

        return view('contact', [
            'visitSchedules' => $visitSchedules,
        ]);
    }

    public function zakaziPoseta()
    {
        $visitSchedules = Cache::remember('visit_schedules_active', 3600, fn() =>
            VisitSchedule::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
        );

        return view('zakaziposeta', [
            'visitSchedules' => $visitSchedules,
        ]);
    }

    /**
     * Store contact complaints/praise messages.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:Пофалба,Жалба,Прашање'],
            'submitted_by_name' => ['required', 'string', 'max:150'],
            'submitted_by_email' => ['nullable', 'email', 'max:150'],
            'submitted_by_phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string'],
        ]);

        Complaint::create([
            'submitted_by_name' => $validated['submitted_by_name'],
            'submitted_by_email' => $validated['submitted_by_email'] ?? null,
            'submitted_by_phone' => $validated['submitted_by_phone'] ?? null,
            'subject' => $validated['type'] . ' - ' . $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Вашата порака е успешно испратена.');
    }

    public function storeVisitRequest(Request $request)
    {
        $validated = $request->validate([
            'visitor_first_name' => ['required', 'string', 'max:100'],
            'visitor_last_name' => ['required', 'string', 'max:100'],
            'visitor_email' => ['nullable', 'email', 'max:150'],
            'visitor_phone' => ['nullable', 'string', 'max:50'],
            'visitor_relation_type' => ['required', 'in:family,friend,other'],
            'requested_inmate_number' => ['required', 'string', 'max:50'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'visit_schedule_id' => ['required', 'exists:visit_schedules,id'],
            'companions' => ['nullable', 'string'],
            'confirm_check' => ['accepted'],
        ]);

        $schedule = VisitSchedule::where('is_active', true)->findOrFail($validated['visit_schedule_id']);
        $visitDate = Carbon::parse($validated['visit_date']);

        if (! $this->isScheduleAllowedForDate($schedule->days_label, $visitDate)) {
            throw ValidationException::withMessages([
                'visit_date' => 'Избраниот датум не одговара на термините за оваа група.',
            ]);
        }

        [$startTime, $endTime] = $this->parseTimeRange($schedule->time_range);

        $timeSlot = TimeSlot::firstOrCreate(
            [
                'date' => $visitDate->format('Y-m-d'),
                'start_time' => $startTime,
                'end_time' => $endTime,
            ],
            [
                'group_template_id' => null,
                'capacity_total' => 15,
                'capacity_used' => 0,
                'is_active' => true,
                'created_by' => null,
            ]
        );

        $inmate = Inmate::firstOrCreate(
            ['inmate_number' => $validated['requested_inmate_number']],
            [
                'first_name' => 'Непознат',
                'last_name' => 'Осуден',
                'status' => 'active',
            ]
        );

        $visitRequest = DB::transaction(function () use ($validated, $visitDate, $schedule, $timeSlot, $inmate, $startTime) {
            $visitRequest = VisitRequest::create([
                'visitor_first_name' => $validated['visitor_first_name'],
                'visitor_last_name' => $validated['visitor_last_name'],
                'visitor_email' => $validated['visitor_email'] ?? null,
                'visitor_phone' => $validated['visitor_phone'] ?? null,
                'visitor_relation_type' => $validated['visitor_relation_type'],
                'inmate_id' => $inmate->id,
                'requested_inmate_number' => $validated['requested_inmate_number'],
                'visit_date' => $visitDate->format('Y-m-d'),
                'visit_schedule_id' => $schedule->id,
                'time_slot_id' => $timeSlot->id,
                'status' => 'approved',
                'cancel_deadline' => Carbon::parse($visitDate->format('Y-m-d') . ' ' . $startTime)->subHours(48),
            ]);

            $companionNames = preg_split('/\r\n|\r|\n/', (string) ($validated['companions'] ?? ''));
            foreach ($companionNames as $companionName) {
                $companionName = trim($companionName);
                if ($companionName === '') {
                    continue;
                }

                [$firstName, $lastName] = $this->splitFullName($companionName);

                VisitCompanion::create([
                    'visit_id' => $visitRequest->id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'relation_to_visitor' => 'companion',
                    'is_child' => false,
                ]);
            }

            $confirmationCode = $this->generateVisitConfirmationCode();
            $qrToken = (string) Str::uuid();
            $pdfPath = 'visit-confirmations/visit-' . $visitRequest->id . '-' . $confirmationCode . '.pdf';

            $confirmation = VisitConfirmation::create([
                'visit_id' => $visitRequest->id,
                'confirmation_code' => $confirmationCode,
                'qr_code_token' => $qrToken,
                'pdf_url' => $pdfPath,
                'issued_at' => now(),
                'valid_until' => Carbon::parse($visitRequest->visit_date)->endOfDay(),
            ]);

            $pdf = Pdf::loadView('pdf.visit-confirmation', [
                'visitRequest' => $visitRequest->load(['visitSchedule', 'timeSlot', 'companions']),
                'confirmation' => $confirmation,
            ])->setPaper('a4');

            Storage::disk('public')->put($pdfPath, $pdf->output());

            return $visitRequest->load('confirmation');
        });

        $confirmation = $visitRequest->confirmation;

        return response()->download(
            Storage::disk('public')->path($confirmation->pdf_url),
            'potvrda-poseta-' . $confirmation->confirmation_code . '.pdf'
        );
    }

    /**
     * Show the soopstenija page
     */
    public function soopstenija(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $query = Announcement::active()->published()->sorted();

        if ($search !== '') {
            // Search in the JSON title/content columns at DB level (no PHP loop)
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(content) LIKE ?', ['%' . mb_strtolower($search) . '%']);
            });
        }

        $announcements = $query->get();

        return view('soopstenija', [
            'announcements' => $announcements,
            'search' => $search,
        ]);
    }

    /**
     * Show the izrabotki page
     */
    public function izrabotki()
    {
        $locale = app()->getLocale();
        $iz = Cache::remember('izrabotki_page_data_' . $locale, 3600, fn() =>
            app(IzrabotkiPageController::class)->publicData()
        );

        return view('izrabotki', compact('iz'));
    }

    /**
     * Show izrabotki section detail
     */
    public function izrabotakiSection($index)
    {
        $locale = app()->getLocale();
        $iz = Cache::remember('izrabotki_page_data_' . $locale, 3600, fn() =>
            app(IzrabotkiPageController::class)->publicData()
        );
        $sections = $iz['sections'] ?? [];

        if (!isset($sections[$index])) {
            abort(404);
        }

        $section = $sections[$index];

        return view('izrabotaki-section-detail', compact('section', 'index', 'iz'));
    }

    /**
     * Show the gallery page
     */
    public function gallery()
    {
        $galleryImages = Cache::remember('gallery_page_all', 600, fn() =>
            GalleryImage::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
        );

        return view('gallery', compact('galleryImages'));
    }

    /**
     * Show a handcraft detail page
     */
    public function handcraftDetail(Handcraft $handcraft)
    {
        if (! $handcraft->is_published) {
            abort(404);
        }

        // Eager load images so the view doesn't trigger separate queries
        $handcraft->load('images');

        // Related handcrafts: cached per handcraft to avoid inRandomOrder() full table scan
        $relatedHandcrafts = Cache::remember('related_handcrafts_' . $handcraft->id, 600, fn() =>
            Handcraft::where('is_published', true)
                ->where('id', '!=', $handcraft->id)
                ->inRandomOrder()
                ->limit(3)
                ->get()
        );

        return view('handcraft-detail', compact('handcraft', 'relatedHandcrafts'));
    }

    private function isScheduleAllowedForDate(string $daysLabel, Carbon $visitDate): bool
    {
        $dayOfWeek = (int) $visitDate->dayOfWeek;

        if (str_contains($daysLabel, 'Понеделник') && str_contains($daysLabel, 'Петок')) {
            return in_array($dayOfWeek, [1, 2, 3, 4, 5], true);
        }

        if (str_contains($daysLabel, 'Понеделник') && str_contains($daysLabel, 'Четврток')) {
            return in_array($dayOfWeek, [1, 2, 3, 4], true);
        }

        if (str_contains($daysLabel, 'Сабота') || str_contains($daysLabel, 'недела')) {
            return in_array($dayOfWeek, [0, 6], true);
        }

        return true;
    }

    private function parseTimeRange(string $timeRange): array
    {
        $parts = preg_split('/\s*[–—-]\s*/u', trim($timeRange));

        if (! is_array($parts) || count($parts) !== 2) {
            throw ValidationException::withMessages([
                'visit_schedule_id' => 'Терминот не е во очекуван формат.',
            ]);
        }

        return [$parts[0], $parts[1]];
    }

    private function splitFullName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName), 2);

        return [$parts[0] ?? '', $parts[1] ?? ''];
    }

    private function generateVisitConfirmationCode(): string
    {
        do {
            $code = (string) random_int(10000, 99999);
        } while (VisitConfirmation::where('confirmation_code', $code)->exists());

        return $code;
    }
}
