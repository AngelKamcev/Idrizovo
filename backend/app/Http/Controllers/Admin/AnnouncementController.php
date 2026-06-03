<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::sorted()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_mk'   => 'required|string|max:255',
            'content_mk' => 'required|string',
            'title_en'   => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'title_sq'   => 'nullable|string|max:255',
            'content_sq' => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'  => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title' => [
                'mk' => $validated['title_mk'],
                'en' => (trim($validated['title_en'] ?? '') ?: $validated['title_mk']),
                'sq' => (trim($validated['title_sq'] ?? '') ?: $validated['title_mk']),
            ],
            'content' => [
                'mk' => $validated['content_mk'],
                'en' => (trim($validated['content_en'] ?? '') ?: $validated['content_mk']),
                'sq' => (trim($validated['content_sq'] ?? '') ?: $validated['content_mk']),
            ],
            'is_active'  => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create($data);
        Cache::forget('nav_announcements');
        Cache::forget('home_announcements');

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Соопштењето е успешно додадено.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title_mk'   => 'required|string|max:255',
            'content_mk' => 'required|string',
            'title_en'   => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'title_sq'   => 'nullable|string|max:255',
            'content_sq' => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'  => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title' => [
                'mk' => $validated['title_mk'],
                'en' => (trim($validated['title_en'] ?? '') ?: ($announcement->getTranslation('title', 'en') ?: $validated['title_mk'])),
                'sq' => (trim($validated['title_sq'] ?? '') ?: ($announcement->getTranslation('title', 'sq') ?: $validated['title_mk'])),
            ],
            'content' => [
                'mk' => $validated['content_mk'],
                'en' => (trim($validated['content_en'] ?? '') ?: ($announcement->getTranslation('content', 'en') ?: $validated['content_mk'])),
                'sq' => (trim($validated['content_sq'] ?? '') ?: ($announcement->getTranslation('content', 'sq') ?: $validated['content_mk'])),
            ],
            'is_active'  => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($announcement->image_path && Storage::disk('public')->exists($announcement->image_path)) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);
        Cache::forget('nav_announcements');
        Cache::forget('home_announcements');

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Соопштењето е успешно изменето.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->image_path && Storage::disk('public')->exists($announcement->image_path)) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();
        Cache::forget('nav_announcements');
        Cache::forget('home_announcements');

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Соопштењето е успешно избришано.');
    }
}
