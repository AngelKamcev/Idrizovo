@extends('admin.layouts.app')

@section('title', 'Уреди активност')
@section('page-title', 'Уреди активност')
@section('page-subtitle', 'Променете ги деталите на активноста')

@section('content')

<!-- BACK BUTTON -->
<div class="mb-6">
    <a href="{{ route('admin.main-activities.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Назад на активности
    </a>
</div>

<!-- FORM CARD -->
<div class="card max-w-2xl">
    <form action="{{ route('admin.main-activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- TITLE -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Назив на активност <span class="text-red-500">*</span></label>
            <input type="text" name="title_mk" value="{{ old('title_mk', $activity->getTranslation('title', 'mk')) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('title_mk') border-red-500 @enderror"
                   placeholder="Напишите назив на активност" required>
            @error('title_mk')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис (Македонски) <span class="text-red-500">*</span></label>
            <textarea name="description_mk" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('description_mk') border-red-500 @enderror"
                      placeholder="Напишите опис на активност" required>{{ old('description_mk', $activity->getTranslation('description', 'mk')) }}</textarea>
            @error('description_mk')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        @include('admin.partials.ai-translate', [
            'buttonId' => 'activityEditTranslate',
            'fieldMap' => [
                'title' => ['mk' => 'title_mk', 'en' => 'title_en', 'sq' => 'title_sq'],
                'description' => ['mk' => 'description_mk', 'en' => 'description_en', 'sq' => 'description_sq'],
            ],
        ])

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Назив (Англиски)</label>
            <input type="text" name="title_en" value="{{ old('title_en', $activity->getTranslation('title', 'en')) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Назив (Албански)</label>
            <input type="text" name="title_sq" value="{{ old('title_sq', $activity->getTranslation('title', 'sq')) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис (Англиски)</label>
            <textarea name="description_en" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">{{ old('description_en', $activity->getTranslation('description', 'en')) }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис (Албански)</label>
            <textarea name="description_sq" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">{{ old('description_sq', $activity->getTranslation('description', 'sq')) }}</textarea>
        </div>

        <!-- CONTENT -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Содржина</label>
            <textarea name="content" rows="6"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('content') border-red-500 @enderror"
                      placeholder="Дополнителна содржина (опционално)">{{ old('content', $activity->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- IMAGE PREVIEW -->
        @if($activity->getImageUrl())
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Тренутна слика</label>
                <img src="{{ $activity->getImageUrl() }}" alt="Слика" class="max-w-xs rounded-lg">
            </div>
        @endif

        <!-- IMAGE FILE INPUT -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Промени слика</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('image') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Максимална величина: 2MB (JPEG, PNG, GIF)</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- ICON -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Икона (Font Awesome class)</label>
            <input type="text" name="icon" value="{{ old('icon', $activity->icon) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('icon') border-red-500 @enderror"
                   placeholder="fas fa-star">
            @error('icon')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- SORT ORDER -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Редослед за приказ</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $activity->sort_order) }}" min="0"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('sort_order') border-red-500 @enderror"
                   placeholder="0">
            @error('sort_order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- STATUS -->
        <div class="mb-6">
            <label class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $activity->is_active) ? 'checked' : '' }} class="rounded">
                <span class="text-sm font-semibold text-gray-700">Активна активност</span>
            </label>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-3 justify-end">
            <a href="{{ route('admin.main-activities.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-2"></i> Откажи
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Зачувај промени
            </button>
        </div>
    </form>
</div>

@endsection
