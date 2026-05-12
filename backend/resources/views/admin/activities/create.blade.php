@extends('admin.layouts.app')

@section('title', 'Нова активност')
@section('page-title', 'Нова активност')
@section('page-subtitle', 'Создајте нова активност за почетната страна')

@section('content')

<!-- BACK BUTTON -->
<div class="mb-6">
    <a href="{{ route('admin.main-activities.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Назад на активности
    </a>
</div>

<!-- FORM CARD -->
<div class="card max-w-2xl">
    <form action="{{ route('admin.main-activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- TITLE -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Назив на активност <span class="text-red-500">*</span></label>
            <input type="text" name="title_mk" value="{{ old('title_mk') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('title_mk') border-red-500 @enderror"
                   placeholder="Напишите назив на активност" required>
            @error('title_mk')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис <span class="text-red-500">*</span></label>
            <textarea name="description_mk" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('description_mk') border-red-500 @enderror"
                      placeholder="Напишите опис на активност" required>{{ old('description_mk') }}</textarea>
            @error('description_mk')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- CONTENT -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Содржина</label>
            <textarea name="content" rows="6"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('content') border-red-500 @enderror"
                      placeholder="Дополнителна содржина (опционално)">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- IMAGE FILE INPUT -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Слика</label>
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
            <input type="text" name="icon" value="{{ old('icon') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('icon') border-red-500 @enderror"
                   placeholder="fas fa-star">
            @error('icon')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- SORT ORDER -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Редослед за приказ</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('sort_order') border-red-500 @enderror"
                   placeholder="0">
            @error('sort_order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- STATUS -->
        <div class="mb-6">
            <label class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded">
                <span class="text-sm font-semibold text-gray-700">Активна активност</span>
            </label>
        </div>

        <!-- AUTO TRANSLATE -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <label class="flex items-center gap-3">
                <input type="checkbox" name="auto_translate" value="1" {{ old('auto_translate', true) ? 'checked' : '' }} class="rounded">
                <span class="text-sm font-semibold text-gray-700">Автоматско преведување на англиски и албански</span>
            </label>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-3 justify-end">
            <a href="{{ route('admin.main-activities.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-2"></i> Откажи
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Создај активност
            </button>
        </div>
    </form>
</div>

@endsection
