<?php

namespace App\Http\Controllers;

use App\Models\Inmate;
use App\Models\TimeSlot;
use App\Models\VisitCompanion;
use App\Models\Complaint;
use App\Models\VisitRequest;
use App\Models\VisitSchedule;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagesController extends Controller
{
    /**
     * Show the index page
     */
    public function index()
    {
        $activities = [
            ['name' => 'Активност 1', 'desc' => 'Описание на активност 1'],
            ['name' => 'Активност 2', 'desc' => 'Описание на активност 2'],
            ['name' => 'Активност 3', 'desc' => 'Описание на активност 3'],
        ];
        return view('index', ['activities' => $activities]);
    }

    /**
     * Show the about us page
     */
    public function aboutus()
    {
        return view('aboutus');
    }

    /**
     * Show the activities page
     */
    public function activities()
    {
        $activities = \App\Models\Activity::active()->sorted()->get();
        return view('activities', ['activities' => $activities]);
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        $visitSchedules = VisitSchedule::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('contact', [
            'visitSchedules' => $visitSchedules,
        ]);
    }

    public function zakaziPoseta()
    {
        $visitSchedules = VisitSchedule::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

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

        return redirect()
            ->route('zakazi-poseta')
            ->with('success', 'Барањето за посета е испратено и е видливо во админ панелот.');
    }

    /**
     * Show the soopstenija page
     */
    public function soopstenija()
    {
        $announcements = Announcement::active()
            ->published()
            ->sorted()
            ->get();

        return view('soopstenija', ['announcements' => $announcements]);
    }

    /**
     * Show the izrabotki page
     */
    public function izrabotki()
    {
        return view('izrabotki');
    }

    /**
     * Show the gallery page
     */
    public function gallery()
    {
        return view('gallery');
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
}
