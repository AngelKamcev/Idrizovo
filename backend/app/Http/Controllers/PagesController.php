<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\VisitSchedule;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show the index page
     */
    public function index()
    {
        $activities = [
            ['name' => 'Активност 1', 'desc' => 'Описание на активност 1'],
            ['name' => 'Активност 2', 'desc' => 'Описание на активност 2'],
            ['name' => 'Активност 3', 'desc' => 'Описание на активност 3'],
        ];
        return view('index', ['activities' => $activities]);
    }

    /**
     * Show the about us page
     */
    public function aboutus()
    {
        return view('aboutus');
    }

    /**
     * Show the activities page
     */
    public function activities()
    {
        return view('activities');
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        $visitSchedules = VisitSchedule::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('contact', [
            'visitSchedules' => $visitSchedules,
        ]);
    }

    /**
     * Store contact complaints/praise messages.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:Пофалба,Жалба,Прашање'],
            'submitted_by_name' => ['required', 'string', 'max:150'],
            'submitted_by_email' => ['nullable', 'email', 'max:150'],
            'submitted_by_phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string'],
        ]);

        Complaint::create([
            'submitted_by_name' => $validated['submitted_by_name'],
            'submitted_by_email' => $validated['submitted_by_email'] ?? null,
            'submitted_by_phone' => $validated['submitted_by_phone'] ?? null,
            'subject' => $validated['type'] . ' - ' . $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Вашата порака е успешно испратена.');
    }

    /**
     * Show the soopstenija page
     */
    public function soopstenija()
    {
        return view('soopstenija');
    }

    /**
     * Show the izrabotki page
     */
    public function izrabotki()
    {
        return view('izrabotki');
    }

    /**
     * Show the gallery page
     */
    public function gallery()
    {
        return view('gallery');
    }
}
