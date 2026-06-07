<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VisitScheduleController extends Controller
{
    public function index()
    {
        $visitSchedules = VisitSchedule::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.visit-schedules', [
            'visitSchedules' => $visitSchedules,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => ['required', 'string', 'max:100'],
            'days_label' => ['required', 'string', 'max:100'],
            'time_range' => ['required', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        VisitSchedule::create([
            'group_name' => $validated['group_name'],
            'days_label' => $validated['days_label'],
            'time_range' => $validated['time_range'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        Cache::forget('visit_schedules_active');
        return redirect()->route('admin.visit-schedules')->with('success', 'Групата е додадена.');
    }

    public function update(Request $request, VisitSchedule $visitSchedule)
    {
        $validated = $request->validate([
            'group_name' => ['required', 'string', 'max:100'],
            'days_label' => ['required', 'string', 'max:100'],
            'time_range' => ['required', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $visitSchedule->update([
            'group_name' => $validated['group_name'],
            'days_label' => $validated['days_label'],
            'time_range' => $validated['time_range'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        Cache::forget('visit_schedules_active');
        return redirect()->route('admin.visit-schedules')->with('success', 'Групата е ажурирана.');
    }

    public function destroy(VisitSchedule $visitSchedule)
    {
        $visitSchedule->delete();

        Cache::forget('visit_schedules_active');
        return redirect()->route('admin.visit-schedules')->with('success', 'Групата е избришана.');
    }
}
