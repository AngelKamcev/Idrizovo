<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitRequest;
use Illuminate\Http\Request;

class VisitRequestController extends Controller
{
    public function index()
    {
        $visitRequests = VisitRequest::with(['visitSchedule', 'timeSlot', 'companions'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.visit-requests', [
            'visitRequests' => $visitRequests,
            'totalRequests' => VisitRequest::count(),
            'approvedRequests' => VisitRequest::where('status', 'approved')->count(),
            'cancelledRequests' => VisitRequest::whereIn('status', ['cancelled_by_visitor', 'cancelled_by_admin'])->count(),
            'completedRequests' => VisitRequest::where('status', 'completed')->count(),
        ]);
    }

    public function update(Request $request, VisitRequest $visitRequest)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,cancelled_by_visitor,cancelled_by_admin,completed,no_show'],
        ]);

        $visitRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.visit-requests')
            ->with('success', 'Барањето за посета е ажурирано.');
    }
}
