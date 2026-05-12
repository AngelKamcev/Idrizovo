<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use App\Services\AutoTranslateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    protected $autoTranslateService;

    public function __construct(AutoTranslateService $autoTranslateService)
    {
        $this->autoTranslateService = $autoTranslateService;
    }

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
            'title_mk' => 'required|string|max:255',
            'content_mk' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'auto_translate' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title' => ['mk' => $validated['title_mk']],
            'content' => ['mk' => $validated['content_mk']],
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
            $data['image_path'] = $imagePath;
        }

        // Auto-translate if requested
        if ($request->boolean('auto_translate')) {
            $data['title']['en'] = $this->autoTranslateService->translate($validated['title_mk'], 'en');
            $data['title']['sq'] = $this->autoTranslateService->translate($validated['title_mk'], 'sq');
            $data['content']['en'] = $this->autoTranslateService->translate($validated['content_mk'], 'en');
            $data['content']['sq'] = $this->autoTranslateService->translate($validated['content_mk'], 'sq');
        } else {
            $data['title']['en'] = $validated['title_mk'];
            $data['title']['sq'] = $validated['title_mk'];
            $data['content']['en'] = $validated['content_mk'];
            $data['content']['sq'] = $validated['content_mk'];
        }

        Announcement::create($data);

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
            'title_mk' => 'required|string|max:255',
            'content_mk' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'auto_translate' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title' => [
                'mk' => $validated['title_mk'],
                'en' => $announcement->getTranslation('title', 'en') ?? $validated['title_mk'],
                'sq' => $announcement->getTranslation('title', 'sq') ?? $validated['title_mk'],
            ],
            'content' => [
                'mk' => $validated['content_mk'],
                'en' => $announcement->getTranslation('content', 'en') ?? $validated['content_mk'],
                'sq' => $announcement->getTranslation('content', 'sq') ?? $validated['content_mk'],
            ],
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        // Handle file upload - delete old if exists and new one is uploaded
        if ($request->hasFile('image')) {
            if ($announcement->image_path && Storage::disk('public')->exists($announcement->image_path)) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
            $data['image_path'] = $imagePath;
        }

        // Auto-translate if requested
        if ($request->boolean('auto_translate')) {
            $data['title']['en'] = $this->autoTranslateService->translate($validated['title_mk'], 'en');
            $data['title']['sq'] = $this->autoTranslateService->translate($validated['title_mk'], 'sq');
            $data['content']['en'] = $this->autoTranslateService->translate($validated['content_mk'], 'en');
            $data['content']['sq'] = $this->autoTranslateService->translate($validated['content_mk'], 'sq');
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Соопштењето е успешно измено.');
    }

    public function destroy(Announcement $announcement)
    {
        // Delete image file if exists
        if ($announcement->image_path && Storage::disk('public')->exists($announcement->image_path)) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Соопштењето е успешно избришано.');
    }
}
