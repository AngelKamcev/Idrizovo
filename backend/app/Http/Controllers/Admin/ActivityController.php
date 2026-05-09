<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\AutoTranslateService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $translateService;

    public function __construct(AutoTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    /**
     * Display a listing of activities
     */
    public function index()
    {
        $activities = Activity::sorted()->paginate(15);
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created activity in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_mk' => 'required|string|max:255',
            'description_mk' => 'required|string|max:1000',
            'content' => 'nullable|string',
            'icon' => 'nullable|string',
            'image_url' => 'nullable|string|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'auto_translate' => 'boolean', // Enable auto-translation
        ]);

        $sourceData = [
            'title' => $validated['title_mk'],
            'description' => $validated['description_mk'],
        ];

        // Auto-translate if enabled
        if ($validated['auto_translate'] ?? true) {
            $translations = $this->translateService->createTranslatableData(
                $sourceData,
                'mk',
                ['en', 'sq']
            );
        } else {
            // Use only source language
            $translations = [
                'title' => ['mk' => $validated['title_mk']],
                'description' => ['mk' => $validated['description_mk']],
            ];
        }

        $activity = Activity::create([
            'title' => $translations['title'],
            'description' => $translations['description'],
            'content' => $validated['content'],
            'icon' => $validated['icon'],
            'image_url' => $validated['image_url'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.activities.index')
            ->with('success', __('Activity created successfully. Auto-translated to EN and SQ.'));
    }

    /**
     * Show the form for editing the specified activity
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity in storage
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title_mk' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_sq' => 'nullable|string|max:255',
            'description_mk' => 'required|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'description_sq' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'icon' => 'nullable|string',
            'image_url' => 'nullable|string|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'auto_translate' => 'boolean',
        ]);

        // Build translations
        $translations = [
            'title' => [
                'mk' => $validated['title_mk'],
                'en' => $validated['title_en'] ?? $validated['title_mk'],
                'sq' => $validated['title_sq'] ?? $validated['title_mk'],
            ],
            'description' => [
                'mk' => $validated['description_mk'],
                'en' => $validated['description_en'] ?? $validated['description_mk'],
                'sq' => $validated['description_sq'] ?? $validated['description_mk'],
            ],
        ];

        // Auto-translate if enabled and some fields are empty
        if ($validated['auto_translate'] ?? true) {
            if (empty($validated['title_en']) || empty($validated['title_sq'])) {
                $autoTranslated = $this->translateService->createTranslatableData(
                    ['title' => $validated['title_mk']],
                    'mk',
                    ['en', 'sq']
                );
                $translations['title'] = array_merge($translations['title'], $autoTranslated['title']);
            }
        }

        $activity->update([
            'title' => $translations['title'],
            'description' => $translations['description'],
            'content' => $validated['content'],
            'icon' => $validated['icon'],
            'image_url' => $validated['image_url'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.activities.index')
            ->with('success', __('Activity updated successfully.'));
    }

    /**
     * Remove the specified activity from storage
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('admin.activities.index')
            ->with('success', __('Activity deleted successfully.'));
    }
}
