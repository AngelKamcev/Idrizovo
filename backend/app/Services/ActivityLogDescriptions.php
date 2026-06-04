<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\GalleryImage;
use App\Models\VisitRequest;
use App\Models\VisitSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ActivityLogDescriptions
{
    private const ROLE_LABELS = [
        'admin' => 'Администратор',
        'vospituvac' => 'Воспитувач',
        'reviewer' => 'Рецензент',
    ];

    /** @var array<string, string> */
    private const STAFF_ACTIONS = [
        'admin.announcements.store' => 'Прикачено соопштение',
        'admin.announcements.update' => 'Изменето соопштение',
        'admin.announcements.destroy' => 'Избришано соопштение',
        'admin.main-activities.store' => 'Прикачена нова активност',
        'admin.main-activities.update' => 'Изменета активност',
        'admin.main-activities.destroy' => 'Избришана активност',
        'admin.gallery.store' => 'Прикачена слика во галерија',
        'admin.gallery.update' => 'Изменета слика во галерија',
        'admin.gallery.destroy' => 'Избришана слика од галерија',
        'admin.izrabotki.update' => 'Ажурирани рачни изработки',
        'admin.aboutus.update' => 'Ажурирана страница За нас',
        'admin.visit-schedules.store' => 'Додаден распоред за посети',
        'admin.visit-schedules.update' => 'Изменет распоред за посети',
        'admin.visit-schedules.destroy' => 'Избришан распоред за посети',
        'admin.visit-requests.update' => 'Променето барање за посета',
        'admin.settings.password' => 'Променета лозинка',
        'admin.settings.users' => 'Додаден нов корисник',
        'admin.complaints.update' => 'Обработена жалба',
        'admin.compliments.update' => 'Обработена пофалба',
        'login' => 'Се најавил на панелот',
        'logout' => 'Се одјавил од панелот',
    ];

    /** @var array<string, string> */
    private const VISIT_STATUS_LABELS = [
        'approved' => 'одобрено',
        'cancelled_by_visitor' => 'откажано од посетител',
        'cancelled_by_admin' => 'откажано од админ',
        'completed' => 'завршено',
        'no_show' => 'не се појавил',
    ];

    /** @var array<string, string> */
    private const SITE_PAGE_VIEW = [
        '' => 'Почетна',
        'about' => 'За нас',
        'activities' => 'Активности',
        'contact' => 'Контакт',
        'soopstenija' => 'Соопштенија',
        'izrabotki' => 'Рачни изработки',
        'gallery' => 'Галерија',
        'zakazi-poseta' => 'Закажување посета',
        'login' => 'Најава',
        'account' => 'Сметка',
    ];

    /** @var array<string, string> */
    private const SITE_PAGE_SUBMIT = [
        'contact' => 'Испратен контакт формулар',
        'zakazi-poseta' => 'Поднесено барање за посета',
        'login' => 'Обид за најава',
        'account' => 'Ажурирана сметка',
    ];

    public static function roleLabel(?string $role): string
    {
        if ($role === null || $role === '') {
            return '—';
        }

        return self::ROLE_LABELS[$role] ?? ucfirst($role);
    }

    public static function forStaffRequest(Request $request, ?string $overrideAction = null): string
    {
        $routeName = self::resolveStaffRouteKey($request, $overrideAction);
        $base = self::STAFF_ACTIONS[$routeName] ?? self::guessStaffActionFromPath($request);
        $detail = self::staffDetail($request, $routeName);

        return $detail !== '' ? "{$base} — {$detail}" : $base;
    }

    public static function forSiteRequest(Request $request): string
    {
        $normalized = self::normalizePublicPath($request->path());
        $routeName = $request->route()?->getName();

        if ($request->isMethod('POST')) {
            $segment = trim($normalized, '/');

            if ($routeName === 'contact.submit' || $segment === 'contact') {
                return self::SITE_PAGE_SUBMIT['contact'];
            }
            if ($routeName === 'zakazi-poseta.submit' || $segment === 'zakazi-poseta') {
                return self::SITE_PAGE_SUBMIT['zakazi-poseta'];
            }
            if ($routeName === 'login.submit' || $segment === 'login') {
                return self::SITE_PAGE_SUBMIT['login'];
            }
            if ($routeName === 'account.update' || $segment === 'account') {
                return self::SITE_PAGE_SUBMIT['account'];
            }

            $page = self::SITE_PAGE_VIEW[$segment] ?? null;

            return $page !== null
                ? "Пополнета форма на {$page}"
                : 'Пополнета форма на сајтот';
        }

        if (preg_match('#^izrabotki/(\d+)$#', $normalized, $m)) {
            return 'Прегледана изработка #'.$m[1];
        }

        if (str_starts_with($normalized, 'izrabotki-section/')) {
            return 'Прегледана секција од изработки';
        }

        $segment = trim($normalized, '/');
        $page = self::SITE_PAGE_VIEW[$segment] ?? null;

        if ($page !== null) {
            return "Отворена страница {$page}";
        }

        return 'Посета на сајтот';
    }

    /**
     * Turns old technical log text (POST admin.announcements.store) into Macedonian.
     *
     * @param  array<string, mixed>  $entry
     */
    public static function humanizeStoredDescription(array $entry, bool $isStaff): string
    {
        $raw = trim((string) ($entry['description'] ?? ''));

        if ($raw === '') {
            if ($isStaff && ! empty($entry['action'])) {
                $raw = (string) $entry['action'];
            } elseif (! $isStaff && ! empty($entry['path'])) {
                return self::humanizeLegacySiteLine($entry);
            }

            return $isStaff ? 'Промена во панелот' : 'Посета на сајтот';
        }

        if (self::looksTechnical($raw)) {
            $routeKey = self::extractRouteKeyFromTechnical($raw);
            if ($routeKey !== null && isset(self::STAFF_ACTIONS[$routeKey])) {
                $base = self::STAFF_ACTIONS[$routeKey];
                $target = trim((string) ($entry['target'] ?? ''));

                return $target !== '' && $target !== 'general' ? "{$base} — {$target}" : $base;
            }

            if ($isStaff) {
                return self::guessStaffActionFromPathString($raw) ?: 'Промена во панелот';
            }

            return self::humanizeLegacySiteLine($entry);
        }

        return $raw;
    }

    private static function resolveStaffRouteKey(Request $request, ?string $overrideAction): string
    {
        if ($overrideAction !== null && $overrideAction !== '') {
            return $overrideAction;
        }

        $name = $request->route()?->getName();
        if ($name) {
            return $name;
        }

        return self::pathAndMethodToRouteKey($request->path(), $request->method());
    }

    private static function pathAndMethodToRouteKey(string $path, string $method): string
    {
        $path = trim($path, '/');
        $method = strtoupper($method);

        $rules = [
            ['#^admin/announcements$#', 'POST', 'admin.announcements.store'],
            ['#^admin/announcements/\d+$#', 'PATCH', 'admin.announcements.update'],
            ['#^admin/announcements/\d+$#', 'PUT', 'admin.announcements.update'],
            ['#^admin/announcements/\d+$#', 'DELETE', 'admin.announcements.destroy'],
            ['#^admin/main-activities$#', 'POST', 'admin.main-activities.store'],
            ['#^admin/main-activities/\d+$#', 'PATCH', 'admin.main-activities.update'],
            ['#^admin/main-activities/\d+$#', 'DELETE', 'admin.main-activities.destroy'],
            ['#^admin/gallery$#', 'POST', 'admin.gallery.store'],
            ['#^admin/gallery/\d+$#', 'PATCH', 'admin.gallery.update'],
            ['#^admin/gallery/\d+$#', 'DELETE', 'admin.gallery.destroy'],
            ['#^admin/izrabotki$#', 'POST', 'admin.izrabotki.update'],
            ['#^admin/aboutus$#', 'POST', 'admin.aboutus.update'],
            ['#^admin/visit-schedules$#', 'POST', 'admin.visit-schedules.store'],
            ['#^admin/visit-schedules/\d+$#', 'PATCH', 'admin.visit-schedules.update'],
            ['#^admin/visit-schedules/\d+$#', 'DELETE', 'admin.visit-schedules.destroy'],
            ['#^admin/visit-requests/\d+$#', 'PATCH', 'admin.visit-requests.update'],
            ['#^admin/settings/password$#', 'POST', 'admin.settings.password'],
            ['#^admin/settings/users$#', 'POST', 'admin.settings.users'],
            ['#^admin/complaints/\d+$#', 'PATCH', 'admin.complaints.update'],
            ['#^admin/compliments/\d+$#', 'PATCH', 'admin.compliments.update'],
        ];

        foreach ($rules as [$pattern, $ruleMethod, $key]) {
            if ($method === $ruleMethod && preg_match($pattern, $path)) {
                return $key;
            }
        }

        return '';
    }

    private static function guessStaffActionFromPath(Request $request): string
    {
        $key = self::pathAndMethodToRouteKey($request->path(), $request->method());

        return self::STAFF_ACTIONS[$key] ?? self::guessStaffActionFromPathString($request->path());
    }

    private static function guessStaffActionFromPathString(string $pathOrText): string
    {
        $text = strtolower($pathOrText);

        if (str_contains($text, 'announcement') || str_contains($text, 'soopstenija')) {
            return 'Работа со соопштение';
        }
        if (str_contains($text, 'main-activities') || str_contains($text, 'activities')) {
            return 'Работа со активност';
        }
        if (str_contains($text, 'gallery')) {
            return 'Работа со галерија';
        }
        if (str_contains($text, 'izrabotki')) {
            return 'Работа со изработки';
        }
        if (str_contains($text, 'aboutus')) {
            return 'Работа со За нас';
        }
        if (str_contains($text, 'visit-schedule')) {
            return 'Работа со распоред за посети';
        }
        if (str_contains($text, 'visit-request')) {
            return 'Работа со барање за посета';
        }
        if (str_contains($text, 'settings')) {
            return 'Промена во поставки';
        }
        if (str_contains($text, 'complaint')) {
            return 'Работа со жалба';
        }
        if (str_contains($text, 'compliment')) {
            return 'Работа со пофалба';
        }

        return 'Промена во панелот';
    }

    private static function looksTechnical(string $text): bool
    {
        if (preg_match('#^(GET|POST|PATCH|PUT|DELETE)\s+#i', $text)) {
            return true;
        }

        if (preg_match('#\badmin\.[a-z0-9_.-]+#i', $text)) {
            return true;
        }

        return in_array(strtolower($text), ['get', 'post', 'patch', 'put', 'delete'], true);
    }

    private static function extractRouteKeyFromTechnical(string $text): ?string
    {
        if (preg_match('#(?:GET|POST|PATCH|PUT|DELETE)\s+([a-z0-9_.-]+)#i', $text, $m)) {
            return strtolower($m[1]);
        }

        if (preg_match('#\b(admin\.[a-z0-9_.-]+)#i', $text, $m)) {
            return strtolower($m[1]);
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $entry
     */
    private static function humanizeLegacySiteLine(array $entry): string
    {
        $path = (string) ($entry['path'] ?? '');
        $segment = self::normalizePublicPath(ltrim($path, '/'));
        $method = strtoupper((string) ($entry['method'] ?? 'GET'));

        if ($method === 'POST') {
            $page = self::SITE_PAGE_VIEW[trim($segment, '/')] ?? null;

            return $page !== null ? "Пополнета форма на {$page}" : 'Пополнета форма на сајтот';
        }

        $page = self::SITE_PAGE_VIEW[trim($segment, '/')] ?? null;

        return $page !== null ? "Отворена страница {$page}" : 'Посета на сајтот';
    }

    private static function staffDetail(Request $request, string $routeName): string
    {
        return match (true) {
            str_starts_with($routeName, 'admin.announcements.') => self::modelTitle(
                $request->route('announcement'),
                $request->input('title_mk'),
            ),
            str_starts_with($routeName, 'admin.main-activities.') => self::modelTitle(
                $request->route('activity'),
                $request->input('title_mk'),
            ),
            str_starts_with($routeName, 'admin.gallery.') => self::galleryDetail($request),
            $routeName === 'admin.visit-requests.update' => self::visitRequestDetail($request),
            $routeName === 'admin.visit-schedules.store',
            $routeName === 'admin.visit-schedules.update' => self::scheduleDetail($request),
            $routeName === 'admin.settings.users' => self::newUserDetail($request),
            $routeName === 'admin.complaints.update',
            $routeName === 'admin.compliments.update' => self::statusDetail($request),
            default => self::genericDetail($request),
        };
    }

    private static function modelTitle(mixed $model, mixed $inputTitle): string
    {
        return self::titleFromModel($model) ?: self::clean((string) $inputTitle);
    }

    private static function titleFromModel(mixed $model): string
    {
        if (! $model instanceof Model) {
            return '';
        }

        if (method_exists($model, 'getTranslation')) {
            $title = $model->getTranslation('title', 'mk', false)
                ?: $model->getTranslation('title', 'mk');

            return self::clean((string) $title);
        }

        return self::clean((string) ($model->title ?? $model->name ?? ''));
    }

    private static function galleryDetail(Request $request): string
    {
        $image = $request->route('galleryImage');
        if ($image instanceof GalleryImage) {
            return self::clean($image->adminTitle());
        }

        return self::clean((string) $request->input('title', $request->input('caption', '')));
    }

    private static function visitRequestDetail(Request $request): string
    {
        $visit = $request->route('visitRequest');
        $statusKey = (string) $request->input('status', '');
        $status = self::VISIT_STATUS_LABELS[$statusKey] ?? self::clean($statusKey);

        if ($visit instanceof VisitRequest) {
            $name = trim($visit->visitor_first_name.' '.$visit->visitor_last_name);
            $parts = array_filter([
                $name !== '' ? $name : null,
                $status !== '' ? $status : null,
            ]);

            return implode(', ', $parts);
        }

        return $status;
    }

    private static function scheduleDetail(Request $request): string
    {
        $schedule = $request->route('visitSchedule');
        if ($schedule instanceof VisitSchedule) {
            $parts = array_filter([
                self::clean((string) ($schedule->group_name ?? '')),
                self::clean((string) ($schedule->days_label ?? '')),
                self::clean((string) ($schedule->time_range ?? '')),
            ]);

            if ($parts !== []) {
                return implode(', ', $parts);
            }
        }

        return self::clean((string) $request->input('group_name', ''));
    }

    private static function newUserDetail(Request $request): string
    {
        $name = trim($request->input('first_name', '').' '.$request->input('last_name', ''));
        $email = self::clean((string) $request->input('email', ''));
        $role = self::roleLabel($request->input('role_name'));

        return implode(', ', array_filter([
            $name !== '' ? $name : null,
            $email !== '' ? $email : null,
            $role !== '—' ? $role : null,
        ]));
    }

    private static function statusDetail(Request $request): string
    {
        $statusKey = (string) $request->input('status', '');

        return self::VISIT_STATUS_LABELS[$statusKey] ?? self::clean($statusKey);
    }

    private static function genericDetail(Request $request): string
    {
        foreach (['title_mk', 'title', 'name', 'group_name'] as $key) {
            $value = self::clean((string) $request->input($key, ''));
            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }

    public static function normalizePublicPath(string $path): string
    {
        $path = trim($path, '/');

        if (preg_match('#^(mk|en|sq)(/.*)?$#', $path, $matches)) {
            $path = isset($matches[2]) ? trim($matches[2], '/') : '';
        }

        return $path;
    }

    private static function clean(string $value): string
    {
        $value = trim(preg_replace('/\s+/', ' ', strip_tags($value)) ?? '');

        return mb_strlen($value) > 120 ? mb_substr($value, 0, 117).'…' : $value;
    }
}
