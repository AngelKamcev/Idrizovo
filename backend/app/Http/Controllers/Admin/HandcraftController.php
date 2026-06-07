<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Handcraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class HandcraftController extends Controller
{
    public function index()
    {
        $query = Handcraft::orderByDesc('created_at');

        if (Cache::remember('table_exists_handcraft_images', 86400, fn() => Schema::hasTable('handcraft_images'))) {
            $query->withCount('images');
        }

        $handcrafts = $query->paginate(12);

        return view('admin.izrabotki', compact('handcrafts'));
    }

    public function create()
    {
        return view('admin.izrabotki_create');
    }

    public function store(Request $request)
    {
        if (! Cache::remember('table_exists_handcraft_images', 86400, fn() => Schema::hasTable('handcraft_images'))) {
            throw ValidationException::withMessages([
                'images' => 'Недостасува табелата за дополнителни слики. Пушти: php artisan migrate',
            ]);
        }

        $validated = $request->validate([
            'title_mk' => ['required', 'string', 'max:200'],
            'description_mk' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'extra_image_1' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'extra_image_2' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'extra_image_3' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $imagePath = $request->file('image')->store('handcrafts', 'public');

        $handcraft = Handcraft::create([
            'title_mk' => $validated['title_mk'],
            'title_en' => $request->input('title_en') ?: $validated['title_mk'],
            'title_al' => $request->input('title_al') ?: $validated['title_mk'],
            'description_mk' => $validated['description_mk'],
            'description_en' => $request->input('description_en') ?: $validated['description_mk'],
            'description_al' => $request->input('description_al') ?: $validated['description_mk'],
            'image_url' => $imagePath,
            'is_published' => $request->boolean('is_published', true),
            'created_by' => $request->user()->id,
            'published_at' => now(),
        ]);

        $additionalFiles = [
            $request->file('extra_image_1'),
            $request->file('extra_image_2'),
            $request->file('extra_image_3'),
            ...$request->file('images', []),
        ];

        foreach (array_values(array_filter($additionalFiles)) as $index => $imageFile) {
            $extraPath = $imageFile->store('handcrafts', 'public');

            $handcraft->images()->create([
                'image_url' => $extraPath,
                'sort_order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.izrabotki')
            ->with('success', 'Изработката е успешно додадена (минимум 4 слики).');
    }

    public function edit(Handcraft $handcraft)
    {
        if (Cache::remember('table_exists_handcraft_images', 86400, fn() => Schema::hasTable('handcraft_images'))) {
            $handcraft->load('images');
        }

        return view('admin.izrabotki_edit', compact('handcraft'));
    }

    public function update(Request $request, Handcraft $handcraft)
    {
        if (! Cache::remember('table_exists_handcraft_images', 86400, fn() => Schema::hasTable('handcraft_images'))) {
            throw ValidationException::withMessages([
                'images' => 'Недостасува табелата за дополнителни слики. Пушти: php artisan migrate',
            ]);
        }

        $validated = $request->validate([
            'title_mk' => ['required', 'string', 'max:200'],
            'description_mk' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => ['integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $handcraft->load('images');

        $imagePath = $handcraft->image_url;
        if ($request->hasFile('image')) {
            if ($handcraft->image_url && ! preg_match('/^https?:\/\//i', $handcraft->image_url) && Storage::disk('public')->exists($handcraft->image_url)) {
                Storage::disk('public')->delete($handcraft->image_url);
            }
            $imagePath = $request->file('image')->store('handcrafts', 'public');
        }

        $removeIds = collect($request->input('remove_image_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($removeIds->isNotEmpty()) {
            $imagesToRemove = $handcraft->images->whereIn('id', $removeIds->all());

            foreach ($imagesToRemove as $image) {
                if ($image->image_url && ! preg_match('/^https?:\/\//i', $image->image_url) && Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }

                $image->delete();
            }
        }

        $nextSort = ((int) $handcraft->images()->max('sort_order')) + 1;
        foreach ($request->file('images', []) as $imageFile) {
            $extraPath = $imageFile->store('handcrafts', 'public');
            $handcraft->images()->create([
                'image_url' => $extraPath,
                'sort_order' => $nextSort++,
            ]);
        }

        $extraCount = $handcraft->images()->count();
        if (1 + $extraCount < 4) {
            throw ValidationException::withMessages([
                'images' => 'За една изработка потребни се најмалку 4 слики вкупно (главна + 3 дополнителни).',
            ]);
        }

        $handcraft->update([
            'title_mk' => $validated['title_mk'],
            'title_en' => $request->input('title_en') ?: $validated['title_mk'],
            'title_al' => $request->input('title_al') ?: $validated['title_mk'],
            'description_mk' => $validated['description_mk'],
            'description_en' => $request->input('description_en') ?: $validated['description_mk'],
            'description_al' => $request->input('description_al') ?: $validated['description_mk'],
            'image_url' => $imagePath,
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $request->boolean('is_published', true) ? ($handcraft->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.izrabotki')
            ->with('success', 'Изработката е успешно изменета.');
    }

    public function destroy(Handcraft $handcraft)
    {
        if (Cache::remember('table_exists_handcraft_images', 86400, fn() => Schema::hasTable('handcraft_images'))) {
            $handcraft->load('images');
        }

        if (Cache::remember('table_exists_handcraft_images', 86400, fn() => Schema::hasTable('handcraft_images'))) {
            foreach ($handcraft->images as $image) {
                if ($image->image_url && ! preg_match('/^https?:\/\//i', $image->image_url) && Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }
        }

        if ($handcraft->image_url && ! preg_match('/^https?:\/\//i', $handcraft->image_url) && Storage::disk('public')->exists($handcraft->image_url)) {
            Storage::disk('public')->delete($handcraft->image_url);
        }

        $handcraft->delete();

        return redirect()->route('admin.izrabotki')
            ->with('success', 'Изработката е успешно избришана.');
    }
}
