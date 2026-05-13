<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compliment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplimentController extends Controller
{
    public function index()
    {
        $compliments = Compliment::orderByDesc('created_at')->paginate(12);

        return view('admin.compliments', [
            'compliments' => $compliments,
            'totalCompliments' => Compliment::count(),
            'newCompliments' => Compliment::where('status', 'new')->count(),
            'seenCompliments' => Compliment::where('status', 'seen')->count(),
            'closedCompliments' => Compliment::where('status', 'closed')->count(),
        ]);
    }

    public function update(Request $request, Compliment $compliment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,seen,in_progress,closed'],
        ]);

        $compliment->update([
            'status' => $validated['status'],
            'assigned_to' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.compliments')
            ->with('success', 'Пофалбата е ажурирана.');
    }
}
