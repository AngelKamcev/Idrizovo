<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index()
    {
        $galleryImages = GalleryImage::sorted()->paginate(12);

        return view('admin.gallery', compact('galleryImages'));
    }

    public function create()
    {
        return view('admin.gallery_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:300'],
            'album' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        GalleryImage::create([
            'title' => $validated['title'],
            'album' => $validated['album'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.gallery')
            ->with('success', 'Сликата е успешно додадена во галеријата.');
    }

    public function edit(GalleryImage $galleryImage)
    {
        return view('admin.gallery_edit', compact('galleryImage'));
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:300'],
            'album' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $imagePath = $galleryImage->image_path;
        if ($request->hasFile('image')) {
            if ($galleryImage->image_path && !preg_match('/^https?:\/\//i', $galleryImage->image_path) && Storage::disk('public')->exists($galleryImage->image_path)) {
                Storage::disk('public')->delete($galleryImage->image_path);
            }
            $imagePath = $request->file('image')->store('gallery', 'public');
        }

        $galleryImage->update([
            'title' => $validated['title'],
            'album' => $validated['album'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.gallery')
            ->with('success', 'Сликата е успешно изменета.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        if ($galleryImage->image_path && !preg_match('/^https?:\/\//i', $galleryImage->image_path) && Storage::disk('public')->exists($galleryImage->image_path)) {
            Storage::disk('public')->delete($galleryImage->image_path);
        }

        $galleryImage->delete();

        return redirect()->route('admin.gallery')
            ->with('success', 'Сликата е успешно избришана.');
    }
}
