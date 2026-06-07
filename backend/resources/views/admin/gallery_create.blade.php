@extends('admin.layouts.app')

@section('title', 'Додај слика')
@section('page-title', 'Додај слика')
@section('page-subtitle', 'Качи нова слика во галеријата')

@section('content')

<form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="card max-w-3xl">
    @csrf

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Наслов</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Албум</label>
            <input type="text" name="album" value="{{ old('album') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Опис</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Слика</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-4 py-2" accept="image/*" required>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-primary">Зачувај</button>
        <a href="{{ route('admin.gallery') }}" class="btn-secondary">Назад</a>
    </div>
</form>

@endsection
