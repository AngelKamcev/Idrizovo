@extends('admin.layouts.app')

@section('title', 'Уреди категорија')
@section('page-title', 'Уреди категорија')
@section('page-subtitle', $categories[$handcraft->category_slug] ?? $handcraft->category_slug)

@section('content')

<div class="max-w-3xl">

    {{-- Back link --}}
    <a href="{{ route('admin.izrabotki') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-800 text-sm mb-6">
        <i class="fas fa-chevron-left"></i> Назад кон изработки
    </a>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.izrabotki.update', $handcraft->category_slug) }}"
          method="POST" enctype="multipart/form-data"
          class="card space-y-6">
        @csrf
        @method('PATCH')

        {{-- Category slug (read-only info) --}}
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
            <i class="fas fa-tag text-gray-400"></i>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Категорија slug</p>
                <p class="text-sm font-mono text-gray-700">{{ $handcraft->category_slug }}</p>
            </div>
            <div class="ml-auto">
                <a href="{{ route('gallery') }}?category={{ $handcraft->category_slug }}" target="_blank"
                   class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Прегледај галерија
                </a>
            </div>
        </div>

        {{-- Titles --}}
        <div>
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fas fa-heading text-gray-400"></i> Наслов
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Македонски <span class="text-red-500">*</span></label>
                    <input type="text" name="title_mk" value="{{ old('title_mk', $handcraft->title_mk) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                           required />
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Англиски</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $handcraft->title_en) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm" />
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Албански</label>
                    <input type="text" name="title_al" value="{{ old('title_al', $handcraft->title_al) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm" />
                </div>
            </div>
        </div>

        <hr class="border-gray-100">

        {{-- Descriptions --}}
        <div>
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fas fa-align-left text-gray-400"></i> Опис
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Македонски <span class="text-red-500">*</span></label>
                    <textarea name="description_mk" rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm resize-y"
                              required>{{ old('description_mk', $handcraft->description_mk) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Англиски</label>
                    <textarea name="description_en" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm resize-y">{{ old('description_en', $handcraft->description_en) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Албански</label>
                    <textarea name="description_al" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm resize-y">{{ old('description_al', $handcraft->description_al) }}</textarea>
                </div>
            </div>
        </div>

        <hr class="border-gray-100">

        {{-- Images --}}
        <div>
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fas fa-image text-gray-400"></i> Слики
            </h3>

            {{-- Main image --}}
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-500 mb-1">Главна слика (се прикажува на јавната страна)</label>
                @if($handcraft->image_url)
                    <div class="mb-2">
                        <img src="{{ \Illuminate\Support\Str::startsWith($handcraft->image_url, ['http','//']) ? $handcraft->image_url : asset($handcraft->image_url) }}"
                             class="h-32 w-auto rounded-lg object-cover border border-gray-200" />
                        <p class="text-xs text-gray-400 mt-1">Тековна слика. Прикачи нова за да ја замениш.</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </div>

            {{-- Cover image --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Cover слика (опционално, за банер)</label>
                @if($handcraft->cover_image_url)
                    <div class="mb-2">
                        <img src="{{ \Illuminate\Support\Str::startsWith($handcraft->cover_image_url, ['http','//']) ? $handcraft->cover_image_url : asset($handcraft->cover_image_url) }}"
                             class="h-32 w-auto rounded-lg object-cover border border-gray-200" />
                    </div>
                @endif
                <input type="file" name="cover_image" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </div>
        </div>

        <hr class="border-gray-100">

        {{-- Published toggle --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Видлива на јавната страна</p>
                <p class="text-xs text-gray-400">Ако е исклучено, категоријата нема да се прикажува.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="sr-only peer"
                       {{ old('is_published', $handcraft->is_published) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Зачувај промени
            </button>
            <a href="{{ route('admin.izrabotki') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Откажи
            </a>
        </div>
    </form>
</div>

@endsection
