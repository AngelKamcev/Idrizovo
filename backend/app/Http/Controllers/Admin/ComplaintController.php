<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()?->isReviewer(), 403);

        $complaints = Complaint::orderByDesc('created_at')->paginate(12);

        return view('admin.complaints', [
            'complaints' => $complaints,
            'totalComplaints' => Complaint::count(),
            'newComplaints' => Complaint::where('status', 'new')->count(),
            'seenComplaints' => Complaint::where('status', 'seen')->count(),
            'closedComplaints' => Complaint::where('status', 'closed')->count(),
        ]);
    }

    public function update(Request $request, Complaint $complaint)
    {
        abort_unless(Auth::user()?->isReviewer(), 403);
        $validated = $request->validate([
            'status' => ['required', 'in:new,seen,in_progress,closed'],
        ]);

        $complaint->update([
            'status' => $validated['status'],
            'assigned_to' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.complaints')
            ->with('success', 'Жалбата е ажурирана.');
    }
}
