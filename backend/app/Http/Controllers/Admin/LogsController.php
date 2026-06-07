<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Display the activity log, newest entries first.
     */
    public function index(Request $request)
    {
        $logPath = storage_path('logs/activity.log');

        $lines = [];
        if (file_exists($logPath)) {
            $raw   = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lines = array_reverse($raw); // Newest first
        }

        // Simple filter support
        $filter = $request->query('filter', '');
        if ($filter !== '') {
            $filterLower = strtolower($filter);
            $lines = array_values(array_filter($lines, function ($line) use ($filterLower) {
                return str_contains(strtolower($line), $filterLower);
            }));
        }

        // Paginate manually (100 lines per page)
        $perPage     = 100;
        $page        = max(1, (int) $request->query('page', 1));
        $total       = count($lines);
        $totalPages  = max(1, (int) ceil($total / $perPage));
        $page        = min($page, $totalPages);
        $offset      = ($page - 1) * $perPage;
        $lines       = array_slice($lines, $offset, $perPage);

        return view('admin.logs', compact('lines', 'page', 'totalPages', 'total', 'filter'));
    }

    /**
     * Clear the activity log (admin only).
     */
    public function clear()
    {
        $logPath = storage_path('logs/activity.log');
        if (file_exists($logPath)) {
            file_put_contents($logPath, '');
        }
        return redirect()->route('admin.logs')->with('success', 'Логот е исчистен.');
    }
}
