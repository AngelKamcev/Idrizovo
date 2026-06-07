<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ActivityLogService
{
    private const SITE_PREFIX = 'site-access';

    private const STAFF_PREFIX = 'staff-actions';

    public function logDirectory(): string
    {
        return storage_path('app/activity-logs');
    }

    public function siteAccessLogPath(?Carbon $month = null): string
    {
        return $this->monthlyLogPath(self::SITE_PREFIX, $month);
    }

    public function staffActionsLogPath(?Carbon $month = null): string
    {
        return $this->monthlyLogPath(self::STAFF_PREFIX, $month);
    }

    /**
     * @return array<int, string> Y-m => label
     */
    public function availableMonths(): array
    {
        $months = [];

        foreach ([self::SITE_PREFIX, self::STAFF_PREFIX] as $prefix) {
            foreach ($this->resolveLogFiles($prefix) as $file) {
                $key = $this->monthKeyFromPath($file);
                if ($key !== null) {
                    $months[$key] = $this->formatMonthLabel($key);
                }
            }
        }

        krsort($months);

        if ($months === []) {
            $current = now()->format('Y-m');
            $months[$current] = $this->formatMonthLabel($current);
        }

        return $months;
    }

    public function logSiteAccess(Request $request): void
    {
        if (! $this->shouldLogSiteAccess($request)) {
            return;
        }

        $ip = $request->ip();
        $path = '/'.$request->path();

        if ($request->isMethod('GET')) {
            $throttleKey = 'site_access:'.$ip.':'.$path;
            if (! Cache::add($throttleKey, true, now()->addMinutes(30))) {
                return;
            }
        }

        $this->appendLine($this->siteAccessLogPath(), [
            'at' => now()->toDateTimeString(),
            'ip' => $ip,
            'description' => ActivityLogDescriptions::forSiteRequest($request),
            'visitor' => $request->user()?->name ?: 'Гостин',
            'locale' => app()->getLocale(),
        ]);
    }

    public function logStaffAction(User $user, Request $request, string $description): void
    {
        $user->loadMissing('role');

        $this->appendLine($this->staffActionsLogPath(), [
            'at' => now()->toDateTimeString(),
            'user_name' => $user->name,
            'role_label' => ActivityLogDescriptions::roleLabel($user->role?->name),
            'description' => $description,
            'ip' => $request->ip(),
        ]);
    }

    public function describeStaffRequest(Request $request): string
    {
        return ActivityLogDescriptions::forStaffRequest($request);
    }

    public function readSiteLogs(int $page, int $perPage, string $search = '', ?string $month = null): LengthAwarePaginator
    {
        return $this->paginateEntries(
            $this->readAllEntries(self::SITE_PREFIX, $search, [
                'ip', 'description', 'visitor', 'path', 'method',
            ], isStaff: false, month: $month),
            $page,
            $perPage,
            'site_page',
        );
    }

    public function readStaffLogs(int $page, int $perPage, string $search = '', ?string $month = null): LengthAwarePaginator
    {
        return $this->paginateEntries(
            $this->readAllEntries(self::STAFF_PREFIX, $search, [
                'ip', 'description', 'user_name', 'role_label', 'role', 'action', 'target',
            ], isStaff: true, month: $month),
            $page,
            $perPage,
            'staff_page',
        );
    }

    public function countSiteLogs(?string $month = null): int
    {
        return count($this->readAllEntries(self::SITE_PREFIX, month: $month, isStaff: false));
    }

    public function countStaffLogs(?string $month = null): int
    {
        return count($this->readAllEntries(self::STAFF_PREFIX, month: $month, isStaff: true));
    }

    private function monthlyLogPath(string $prefix, ?Carbon $month = null): string
    {
        $month ??= now();

        return $this->logDirectory().'/'.$prefix.'-'.$month->format('Y-m').'.txt';
    }

    private function appendLine(string $file, array $data): void
    {
        $directory = dirname($file);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $line = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).PHP_EOL;
        file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    }

    /**
     * @return array<int, string>
     */
    private function resolveLogFiles(string $prefix, ?string $month = null): array
    {
        $directory = $this->logDirectory();
        if (! is_dir($directory)) {
            return [];
        }

        if ($month !== null && $month !== '' && $month !== 'all') {
            $monthly = $directory.'/'.$prefix.'-'.$month.'.txt';
            $files = is_file($monthly) ? [$monthly] : [];

            return $files;
        }

        $files = glob($directory.'/'.$prefix.'-*.txt') ?: [];
        $legacy = $directory.'/'.$prefix.'.txt';
        if (is_file($legacy)) {
            $files[] = $legacy;
        }

        rsort($files);

        return $files;
    }

    /**
     * @return array<int, object>
     */
    private function readAllEntries(
        string $prefix,
        string $search = '',
        array $searchFields = [],
        bool $isStaff = false,
        ?string $month = null,
    ): array {
        $entries = [];

        foreach ($this->resolveLogFiles($prefix, $month) as $file) {
            foreach ($this->readFileEntries($file, $search, $searchFields, $isStaff) as $entry) {
                $entries[] = $entry;
            }
        }

        usort($entries, fn ($a, $b) => strcmp((string) ($b->at ?? ''), (string) ($a->at ?? '')));

        return $entries;
    }

    /**
     * @return array<int, object>
     */
    private function readFileEntries(string $file, string $search, array $searchFields, bool $isStaff): array
    {
        if (! is_file($file)) {
            return [];
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return [];
        }

        $entries = [];
        $needle = mb_strtolower($search);

        foreach ($lines as $line) {
            $decoded = json_decode($line, true);
            if (! is_array($decoded)) {
                continue;
            }

            $decoded = $this->normalizeLegacyEntry($decoded, $isStaff);

            if ($needle !== '') {
                $haystack = mb_strtolower((string) ($decoded['description'] ?? ''));
                foreach ($searchFields as $field) {
                    $haystack .= ' '.mb_strtolower((string) ($decoded[$field] ?? ''));
                }
                if (! str_contains($haystack, $needle)) {
                    continue;
                }
            }

            $entries[] = (object) $decoded;
        }

        return $entries;
    }

    /**
     * @param  array<string, mixed>  $entry
     * @return array<string, mixed>
     */
    private function normalizeLegacyEntry(array $entry, bool $isStaff): array
    {
        $entry['description'] = ActivityLogDescriptions::humanizeStoredDescription($entry, $isStaff);

        if ($isStaff && empty($entry['role_label']) && ! empty($entry['role'])) {
            $entry['role_label'] = ActivityLogDescriptions::roleLabel($entry['role']);
        }

        if (! $isStaff && empty($entry['visitor'])) {
            $entry['visitor'] = ! empty($entry['user_name']) ? $entry['user_name'] : 'Гостин';
        }

        return $entry;
    }

    /**
     * @param  array<int, object>  $entries
     */
    private function paginateEntries(array $entries, int $page, int $perPage, string $pageName): LengthAwarePaginator
    {
        $total = count($entries);
        $page = max(1, $page);
        $slice = array_slice($entries, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $slice,
            $total,
            $perPage,
            $page,
            ['pageName' => $pageName, 'path' => request()->url(), 'query' => request()->query()],
        );
    }

    private function monthKeyFromPath(string $path): ?string
    {
        $basename = basename($path, '.txt');
        if (preg_match('#-(20\d{2}-\d{2})$#', $basename, $m)) {
            return $m[1];
        }

        return null;
    }

    private function formatMonthLabel(string $monthKey): string
    {
        try {
            return Carbon::createFromFormat('Y-m', $monthKey)->locale('mk')->translatedFormat('F Y');
        } catch (\Throwable) {
            return $monthKey;
        }
    }

    private function shouldLogSiteAccess(Request $request): bool
    {
        if ($request->is('up') || $request->is('telescope*')) {
            return false;
        }

        if ($request->is('admin*') || $request->is('login*')) {
            return false;
        }

        $path = $request->path();
        if (preg_match('#\.(css|js|map|ico|png|jpe?g|gif|svg|webp|woff2?|ttf)$#i', $path)) {
            return false;
        }

        if (! in_array($request->method(), ['GET', 'POST'], true)) {
            return false;
        }

        return true;
    }
}
