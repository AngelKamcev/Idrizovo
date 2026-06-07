<?php

namespace App\Http\Controllers\Admin;

use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SiteLogController extends Controller
{
    public function __construct(
        private ActivityLogService $activityLog,
    ) {}

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'site');
        if (! in_array($tab, ['site', 'staff'], true)) {
            $tab = 'site';
        }

        $search = trim((string) $request->query('q', ''));
        $perPage = 25;
        $month = $request->query('month', now()->format('Y-m'));
        if ($month === 'all') {
            $monthFilter = 'all';
        } elseif (preg_match('/^\d{4}-\d{2}$/', (string) $month)) {
            $monthFilter = $month;
        } else {
            $monthFilter = now()->format('Y-m');
        }

        $sitePage = max(1, (int) $request->query('site_page', 1));
        $staffPage = max(1, (int) $request->query('staff_page', 1));

        return view('admin.site-logs', [
            'tab' => $tab,
            'search' => $search,
            'month' => $monthFilter,
            'availableMonths' => $this->activityLog->availableMonths(),
            'siteLogs' => $this->activityLog->readSiteLogs($sitePage, $perPage, $search, $monthFilter),
            'staffLogs' => $this->activityLog->readStaffLogs($staffPage, $perPage, $search, $monthFilter),
            'siteTotal' => $this->activityLog->countSiteLogs($monthFilter),
            'staffTotal' => $this->activityLog->countStaffLogs($monthFilter),
        ]);
    }
}
