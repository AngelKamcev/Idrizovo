@extends('admin.layouts.app')

@section('title', 'Галерија')
@section('page-title', 'Галерија')
@section('page-subtitle', 'Качување и уредување на слики (зачувување во база)')

@section('content')

@if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 text-sm">{{ session('success') }}</div>
@endif

<div class="flex items-center justify-between mb-6">
    <a href="{{ route('admin.gallery.create') }}" class="btn-primary">
        <i class="fas fa-upload mr-2"></i> Прикачи слика
    </a>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse ($galleryImages as $image)
        <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all bg-gray-100">
            @if ($image->resolved_url)
                <img src="{{ $image->resolved_url }}" alt="{{ $image->adminTitle() }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
            @else
                <div class="w-full h-48 flex items-center justify-center text-gray-500 text-sm">Нема слика</div>
            @endif
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
                <a href="{{ route('admin.gallery.edit', $image) }}" class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full inline-flex" title="Уреди">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="inline" onsubmit="return confirm('Да се избрише сликата?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full" title="Избриши">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
                <p class="font-semibold truncate">{{ $image->adminTitle() }}</p>
                @if ($image->album)
                    <p class="truncate opacity-90">{{ $image->album }}</p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-600 col-span-full">Нема слики. Кликни „Качи слика“ за да додадеш.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $galleryImages->links() }}
</div>

@endsection
