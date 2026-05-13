<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Handcraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        if ($categorySlug && !array_key_exists($categorySlug, Handcraft::$categories)) {
            $categorySlug = null;
        }

        $query = DB::table('gallery')
            ->join('gallery_categories', 'gallery.category_id', '=', 'gallery_categories.id')
            ->select('gallery.*', 'gallery_categories.name_mk as category_name')
            ->orderByDesc('gallery.created_at');

        if ($categorySlug) {
            $query->where('gallery.handcraft_category', $categorySlug);
        }

        $images = $query->paginate(24);
        $total  = DB::table('gallery')->count();

        return view('admin.gallery', [
            'images'       => $images,
            'total'        => $total,
            'categorySlug' => $categorySlug,
            'categories'   => Handcraft::$categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'images'               => ['required', 'array', 'min:1'],
            'images.*'             => ['required', 'image', 'max:8192'],
            'handcraft_category'   => ['required', 'string'],
            'description_mk'       => ['nullable', 'string', 'max:500'],
        ]);

        abort_unless(array_key_exists($validated['handcraft_category'], Handcraft::$categories), 422);

        // Resolve or create gallery_categories row for this slug
        $catSlug  = $validated['handcraft_category'];
        $catLabel = Handcraft::$categories[$catSlug];
        $catId    = DB::table('gallery_categories')
            ->where('name_mk', $catLabel)
            ->value('id');

        if (!$catId) {
            $catId = DB::table('gallery_categories')->insertGetId([
                'name_mk'   => $catLabel,
                'name_en'   => $catLabel,
                'name_al'   => $catLabel,
                'is_active' => true,
            ]);
        }

        foreach ($request->file('images') as $file) {
            $path = $file->store("gallery/{$catSlug}", 'public');
            DB::table('gallery')->insert([
                'image_url'            => Storage::url($path),
                'description_mk'       => $validated['description_mk'] ?? null,
                'category_id'          => $catId,
                'handcraft_category'   => $catSlug,
                'uploaded_by'          => Auth::id(),
                'is_published'         => true,
                'created_at'           => now(),
            ]);
        }

        return redirect()
            ->route('admin.gallery', ['category' => $catSlug])
            ->with('success', 'Сликите се успешно прикачени.');
    }

    public function destroy(int $id)
    {
        $image = DB::table('gallery')->where('id', $id)->first();
        abort_if(!$image, 404);

        // Delete file from disk
        $relativePath = str_replace('/storage/', '', $image->image_url);
        Storage::disk('public')->delete($relativePath);

        DB::table('gallery')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Сликата е избришана.');
    }
}
