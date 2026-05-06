@extends('admin.layouts.app')

@section('title', 'Рачни Изработки')
@section('page-title', 'Рачни Изработки')
@section('page-subtitle', 'Управување со рачно изработените производи')

@section('content')

<!-- ACTION BAR -->
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-3">
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Нов производ
        </button>
        <input type="text" placeholder="Пребарај производи..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
    </div>
    <div class="flex gap-2">
        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <option>Сите категории</option>
            <option>Плетени предмети</option>
            <option>Резби</option>
            <option>Слики</option>
            <option>Грнчарство</option>
        </select>
    </div>
</div>

<!-- GRID VIEW -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Product Card 1 -->
    <div class="card hover:shadow-lg transition-all">
        <div class="relative mb-4 rounded-lg overflow-hidden bg-gray-200 h-48">
            <img src="https://picsum.photos/400/300?random=1" alt="Производ" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold">
                Плетени
            </div>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Плетена торба</h3>
        <p class="text-sm text-gray-600 mb-4">Традиционална плетена торба од шерствено волно</p>
        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                На стану
            </span>
            <div class="flex gap-2">
                <button class="btn-edit text-xs">Уреди</button>
                <button class="btn-danger text-xs">Избриши</button>
            </div>
        </div>
    </div>

    <!-- Product Card 2 -->
    <div class="card hover:shadow-lg transition-all">
        <div class="relative mb-4 rounded-lg overflow-hidden bg-gray-200 h-48">
            <img src="https://picsum.photos/400/300?random=2" alt="Производ" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 bg-orange-600 text-white px-2 py-1 rounded text-xs font-semibold">
                Резби
            </div>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Дрвена фигура</h3>
        <p class="text-sm text-gray-600 mb-4">Резбана дрвена фигура со религиозни мотиви</p>
        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                На стану
            </span>
            <div class="flex gap-2">
                <button class="btn-edit text-xs">Уреди</button>
                <button class="btn-danger text-xs">Избриши</button>
            </div>
        </div>
    </div>

    <!-- Product Card 3 -->
    <div class="card hover:shadow-lg transition-all">
        <div class="relative mb-4 rounded-lg overflow-hidden bg-gray-200 h-48">
            <img src="https://picsum.photos/400/300?random=3" alt="Производ" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 bg-purple-600 text-white px-2 py-1 rounded text-xs font-semibold">
                Слики
            </div>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Слика на пејзаж</h3>
        <p class="text-sm text-gray-600 mb-4">Акварелна слика на природна средина</p>
        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                Низ процес
            </span>
            <div class="flex gap-2">
                <button class="btn-edit text-xs">Уреди</button>
                <button class="btn-danger text-xs">Избриши</button>
            </div>
        </div>
    </div>

    <!-- Product Card 4 -->
    <div class="card hover:shadow-lg transition-all">
        <div class="relative mb-4 rounded-lg overflow-hidden bg-gray-200 h-48">
            <img src="https://picsum.photos/400/300?random=4" alt="Производ" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold">
                Грнчарство
            </div>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Грнчарска вазна</h3>
        <p class="text-sm text-gray-600 mb-4">Декоративна грнчарска вазна со традиционални мотиви</p>
        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                На стану
            </span>
            <div class="flex gap-2">
                <button class="btn-edit text-xs">Уреди</button>
                <button class="btn-danger text-xs">Избриши</button>
            </div>
        </div>
    </div>

    <!-- Product Card 5 -->
    <div class="card hover:shadow-lg transition-all">
        <div class="relative mb-4 rounded-lg overflow-hidden bg-gray-200 h-48">
            <img src="https://picsum.photos/400/300?random=5" alt="Производ" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold">
                Плетени
            </div>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Плетена кошула</h3>
        <p class="text-sm text-gray-600 mb-4">Традиционална плетена кошула со украси</p>
        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                На стану
            </span>
            <div class="flex gap-2">
                <button class="btn-edit text-xs">Уреди</button>
                <button class="btn-danger text-xs">Избриши</button>
            </div>
        </div>
    </div>

    <!-- Product Card 6 -->
    <div class="card hover:shadow-lg transition-all">
        <div class="relative mb-4 rounded-lg overflow-hidden bg-gray-200 h-48">
            <img src="https://picsum.photos/400/300?random=6" alt="Производ" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 bg-orange-600 text-white px-2 py-1 rounded text-xs font-semibold">
                Резби
            </div>
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Кутијка од дрво</h3>
        <p class="text-sm text-gray-600 mb-4">Резбана дрвена кутијка за украси</p>
        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                Архивирано
            </span>
            <div class="flex gap-2">
                <button class="btn-edit text-xs">Уреди</button>
                <button class="btn-danger text-xs">Избриши</button>
            </div>
        </div>
    </div>
</div>

<!-- PAGINATION -->
<div class="mt-6 flex items-center justify-between">
    <p class="text-sm text-gray-600">Приказ 1-6 од 42 производи</p>
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
