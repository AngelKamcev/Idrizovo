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

        $storedPath = $request->file('image')->store('gallery', 'public');

        $image = new GalleryImage([
            'album' => $validated['album'],
            'description' => $validated['description'] ?? null,
            'image_path' => $storedPath,
            'sort_order' => (int) (GalleryImage::max('sort_order') ?? 0) + 1,
            'is_active' => true,
        ]);
        $this->syncTitleTranslations($image, $validated['title']);
        $image->save();

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

        if ($request->hasFile('image')) {
            $this->deleteStoredPublicImage($galleryImage->image_path);
            $galleryImage->image_path = $request->file('image')->store('gallery', 'public');
        }

        $galleryImage->album = $validated['album'];
        $galleryImage->description = $validated['description'] ?? null;
        $this->syncTitleTranslations($galleryImage, $validated['title']);
        $galleryImage->save();

        return redirect()->route('admin.gallery')
            ->with('success', 'Сликата е успешно изменета.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        $this->deleteStoredPublicImage($galleryImage->image_path);

        $galleryImage->delete();

        return redirect()->route('admin.gallery')
            ->with('success', 'Сликата е успешно избришана.');
    }

    private function syncTitleTranslations(GalleryImage $image, string $title): void
    {
        foreach (['mk', 'en', 'sq'] as $locale) {
            $image->setTranslation('title', $locale, $title);
        }
    }

    /**
     * @param  string|null  $pathOrUrl  Relative path on the public disk (e.g. gallery/foo.jpg), or legacy /storage/... URL.
     */
    private function deleteStoredPublicImage(?string $pathOrUrl): void
    {
        if (! $pathOrUrl || preg_match('#^https?://#i', $pathOrUrl)) {
            return;
        }

        $path = ltrim((string) $pathOrUrl, '/');

        if (str_starts_with($path, 'storage/')) {
            $relative = substr($path, strlen('storage/'));
        } else {
            $relative = $path;
        }

        if ($relative !== '' && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }
}
