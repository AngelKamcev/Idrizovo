<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::sorted()->paginate(15);
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_mk'       => 'required|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'title_sq'       => 'nullable|string|max:255',
            'description_mk' => 'required|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'description_sq' => 'nullable|string|max:1000',
            'content'        => 'nullable|string',
            'icon'           => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order'     => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('activities', 'public');
        }

        Activity::create([
            'title' => [
                'mk' => $validated['title_mk'],
                'en' => (trim($validated['title_en'] ?? '') ?: $validated['title_mk']),
                'sq' => (trim($validated['title_sq'] ?? '') ?: $validated['title_mk']),
            ],
            'description' => [
                'mk' => $validated['description_mk'],
                'en' => (trim($validated['description_en'] ?? '') ?: $validated['description_mk']),
                'sq' => (trim($validated['description_sq'] ?? '') ?: $validated['description_mk']),
            ],
            'content'    => $validated['content'],
            'icon'       => $validated['icon'],
            'image_path' => $imagePath,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        Cache::forget('all_activities');
        foreach (['mk','en','sq'] as $l) { Cache::forget('home_activities_' . $l); }

        return redirect()->route('admin.main-activities.index')
            ->with('success', 'Активноста е успешно создадена.');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title_mk'       => 'required|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'title_sq'       => 'nullable|string|max:255',
            'description_mk' => 'required|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'description_sq' => 'nullable|string|max:1000',
            'content'        => 'nullable|string',
            'icon'           => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order'     => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
        ]);

        $imagePath = $activity->image_path;
        if ($request->hasFile('image')) {
            if ($activity->image_path) {
                \Storage::disk('public')->delete($activity->image_path);
            }
            $imagePath = $request->file('image')->store('activities', 'public');
        }

        $activity->update([
            'title' => [
                'mk' => $validated['title_mk'],
                'en' => (trim($validated['title_en'] ?? '') ?: ($activity->getTranslation('title', 'en') ?: $validated['title_mk'])),
                'sq' => (trim($validated['title_sq'] ?? '') ?: ($activity->getTranslation('title', 'sq') ?: $validated['title_mk'])),
            ],
            'description' => [
                'mk' => $validated['description_mk'],
                'en' => (trim($validated['description_en'] ?? '') ?: ($activity->getTranslation('description', 'en') ?: $validated['description_mk'])),
                'sq' => (trim($validated['description_sq'] ?? '') ?: ($activity->getTranslation('description', 'sq') ?: $validated['description_mk'])),
            ],
            'content'    => $validated['content'],
            'icon'       => $validated['icon'],
            'image_path' => $imagePath,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        Cache::forget('all_activities');
        foreach (['mk','en','sq'] as $l) { Cache::forget('home_activities_' . $l); }

        return redirect()->route('admin.main-activities.index')
            ->with('success', 'Активноста е успешно изменета.');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->image_path) {
            \Storage::disk('public')->delete($activity->image_path);
        }
        $activity->delete();

        Cache::forget('all_activities');
        foreach (['mk','en','sq'] as $l) { Cache::forget('home_activities_' . $l); }

        return redirect()->route('admin.main-activities.index')
            ->with('success', 'Активноста е успешно избришана.');
    }
}
