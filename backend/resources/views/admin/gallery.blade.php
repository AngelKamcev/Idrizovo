@extends('admin.layouts.app')

@section('title', 'Галерија')
@section('page-title', 'Галерија')
@section('page-subtitle', 'Управување со сликите во галеријата')

@section('content')

<!-- ACTION BAR -->
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-3">
        <button class="btn-primary">
            <i class="fas fa-upload mr-2"></i> Качи слика
        </button>
        <input type="text" placeholder="Пребарај слики..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
    </div>
    <div class="flex gap-2">
        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <option>Сите албуми</option>
            <option>Активности</option>
            <option>Установа</option>
            <option>События</option>
        </select>
    </div>
</div>

<!-- GALLERY GRID -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <!-- Gallery Item 1 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=1" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">Активности</p>
        </div>
    </div>

    <!-- Gallery Item 2 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=2" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">События</p>
        </div>
    </div>

    <!-- Gallery Item 3 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=3" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">Установа</p>
        </div>
    </div>

    <!-- Gallery Item 4 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=4" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">Активности</p>
        </div>
    </div>

    <!-- Gallery Item 5 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=5" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">События</p>
        </div>
    </div>

    <!-- Gallery Item 6 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=6" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">Установа</p>
        </div>
    </div>

    <!-- Gallery Item 7 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=7" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">События</p>
        </div>
    </div>

    <!-- Gallery Item 8 -->
    <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
        <img src="https://picsum.photos/300/300?random=8" alt="Слика" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
            <button class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
            <p class="font-semibold">Установа</p>
        </div>
    </div>
</div>

<!-- PAGINATION -->
<div class="mt-6 flex items-center justify-between">
    <p class="text-sm text-gray-600">Приказ 1-8 од 156 слики</p>
    <div class="flex gap-2">
        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="px-3 py-2 bg-blue-600 text-white rounded-lg">1</button>
        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

@endsection
