<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Compliment;

class ReviewerDashboardController extends Controller
{
    public function index()
    {
        $complaints = Complaint::orderByDesc('created_at')->paginate(6);
        $compliments = Compliment::orderByDesc('created_at')->paginate(6);

        return view('admin.reviewer-dashboard', [
            'complaints' => $complaints,
            'compliments' => $compliments,
            'totalComplaints' => Complaint::count(),
            'newComplaints' => Complaint::where('status', 'new')->count(),
            'totalCompliments' => Compliment::count(),
            'newCompliments' => Compliment::where('status', 'new')->count(),
        ]);
    }
}
