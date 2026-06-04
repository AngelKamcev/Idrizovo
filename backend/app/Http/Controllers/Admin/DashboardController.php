<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Complaint;
use App\Models\Compliment;
use App\Models\GalleryImage;
use App\Models\Handcraft;
use App\Models\VisitRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user?->isAdmin();
        $isReviewer = $user?->isReviewer();
        $canSeeContactAlerts = $isAdmin || $isReviewer;
        $today = Carbon::today();

        $newComplaintsCount = Complaint::where('status', 'new')->count();
        $newComplimentsCount = Compliment::where('status', 'new')->count();

        $visitRequestsSubmittedToday = 0;
        $visitsScheduledToday = 0;
        $urgentVisitRequests = collect();
        $urgentNewComplaints = Complaint::where('status', 'new')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        if ($isAdmin) {
            $visitRequestsSubmittedToday = VisitRequest::whereDate('created_at', $today)->count();
            $visitsScheduledToday = VisitRequest::whereDate('visit_date', $today)
                ->where('status', 'approved')
                ->count();

            $urgentVisitRequests = VisitRequest::query()
                ->with(['visitSchedule'])
                ->where(function ($query) use ($today) {
                    $query->whereDate('created_at', $today)
                        ->orWhere(function ($q) use ($today) {
                            $q->whereDate('visit_date', $today)
                                ->where('status', 'approved');
                        });
                })
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }

        $hasAlerts = ($canSeeContactAlerts && ($newComplaintsCount > 0 || $newComplimentsCount > 0))
            || ($isAdmin && ($visitRequestsSubmittedToday > 0 || $visitsScheduledToday > 0));

        $webServerStatus = true;

        try {
            DB::connection()->getPdo();
            $databaseStatus = true;
        } catch (\Throwable $e) {
            $databaseStatus = false;
        }

        try {
            $storageStatus = Storage::disk('public')->exists('.');
        } catch (\Throwable $e) {
            $storageStatus = false;
        }

        try {
            DB::table('handcrafts')->count();
            $handcraftsStatus = true;
        } catch (\Throwable $e) {
            $handcraftsStatus = false;
        }

        return view('admin.dashboard', [
            'canSeeContactAlerts' => $canSeeContactAlerts,
            'activitiesCount' => Activity::count(),
            'announcementsCount' => Announcement::count(),
            'galleryCount' => GalleryImage::count(),
            'handcraftsCount' => Handcraft::count(),
            'visitRequestsCount' => VisitRequest::count(),
            'approvedRequestsCount' => VisitRequest::where('status', 'approved')->count(),
            'complaintsCount' => Complaint::count(),
            'newComplaintsCount' => $newComplaintsCount,
            'complimentsCount' => Compliment::count(),
            'newComplimentsCount' => $newComplimentsCount,
            'visitRequestsSubmittedToday' => $visitRequestsSubmittedToday,
            'visitsScheduledToday' => $visitsScheduledToday,
            'urgentNewComplaints' => $urgentNewComplaints,
            'urgentVisitRequests' => $urgentVisitRequests,
            'hasAlerts' => $hasAlerts,
            'webServerStatus' => $webServerStatus,
            'databaseStatus' => $databaseStatus,
            'storageStatus' => $storageStatus,
            'handcraftsStatus' => $handcraftsStatus,
            'recentAnnouncements' => Announcement::sorted()->take(3)->get(),
            'recentActivities' => Activity::sorted()->take(3)->get(),
            'recentVisitRequests' => VisitRequest::with(['visitSchedule'])->orderByDesc('created_at')->take(3)->get(),
            'recentHandcrafts' => Handcraft::published()->orderByDesc('published_at')->orderByDesc('id')->take(3)->get(),
        ]);
    }
}
