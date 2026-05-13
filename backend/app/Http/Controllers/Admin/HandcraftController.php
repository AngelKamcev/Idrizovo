<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Handcraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HandcraftController extends Controller
{
    /**
     * Show the admin izrabotki management page.
     * Groups handcrafts by their category_slug so the view gets one record per category.
     */
    public function index()
    {
        // We keep exactly one record per category (the editable "section" card).
        // If somehow more than one exists per slug, we take the latest.
        $handcrafts = collect(array_keys(Handcraft::$categories))->mapWithKeys(function ($slug) {
            $record = Handcraft::where('category_slug', $slug)->latest('id')->first();
            return [$slug => $record];
        });

        return view('admin.izrabotki', [
            'handcrafts'  => $handcrafts,
            'categories'  => Handcraft::$categories,
        ]);
    }

    /**
     * Show the edit form for a single category section.
     */
    public function edit(string $slug)
    {
        abort_unless(array_key_exists($slug, Handcraft::$categories), 404);

        $handcraft = Handcraft::where('category_slug', $slug)->latest('id')->firstOrFail();

        return view('admin.handcraft-edit', [
            'handcraft'  => $handcraft,
            'categories' => Handcraft::$categories,
        ]);
    }

    /**
     * Update the content of a category section.
     */
    public function update(Request $request, string $slug)
    {
        abort_unless(array_key_exists($slug, Handcraft::$categories), 404);

        $validated = $request->validate([
            'title_mk'       => ['required', 'string', 'max:200'],
            'title_en'       => ['nullable', 'string', 'max:200'],
            'title_al'       => ['nullable', 'string', 'max:200'],
            'description_mk' => ['required', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_al' => ['nullable', 'string'],
            'image'          => ['nullable', 'image', 'max:4096'],
            'cover_image'    => ['nullable', 'image', 'max:4096'],
            'is_published'   => ['nullable', 'boolean'],
        ]);

        $handcraft = Handcraft::where('category_slug', $slug)->latest('id')->firstOrFail();

        // Handle main image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("handcrafts/{$slug}", 'public');
            $validated['image_url'] = Storage::url($path);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store("handcrafts/{$slug}/covers", 'public');
            $validated['cover_image_url'] = Storage::url($path);
        }

        $handcraft->update([
            'title_mk'        => $validated['title_mk'],
            'title_en'        => $validated['title_en'] ?? null,
            'title_al'        => $validated['title_al'] ?? null,
            'description_mk'  => $validated['description_mk'],
            'description_en'  => $validated['description_en'] ?? null,
            'description_al'  => $validated['description_al'] ?? null,
            'image_url'       => $validated['image_url'] ?? $handcraft->image_url,
            'cover_image_url' => $validated['cover_image_url'] ?? $handcraft->cover_image_url,
            'is_published'    => $request->boolean('is_published', true),
            'updated_at'      => now(),
        ]);

        return redirect()
            ->route('admin.izrabotki')
            ->with('success', 'Категоријата е успешно ажурирана.');
    }
}
