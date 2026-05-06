@extends('admin.layouts.app')

@section('title', 'Активности - Почетна')
@section('page-title', 'Активности на Почетната Страна')
@section('page-subtitle', 'Управување со активностите што се прикажуваат во слајдерот на почетната страна')

@section('content')

<!-- ALERT -->
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg flex gap-3">
    <i class="fas fa-info-circle text-blue-600 text-xl flex-shrink-0 mt-0.5"></i>
    <div class="text-sm">
        <p class="font-semibold text-blue-900">Напомена</p>
        <p class="text-blue-800">Овде може да уредувате активности кои се прикажуваат во каруселот на почетната страна</p>
    </div>
</div>

<!-- ACTION BAR -->
<div class="flex items-center justify-between mb-6">
    <button class="btn-primary">
        <i class="fas fa-plus mr-2"></i> Нова активност
    </button>
    <input type="text" placeholder="Пребарај активности..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
</div>

<!-- CARDS SECTION -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Activity Card 1 -->
    <div class="card">
        <div class="relative mb-4 rounded-lg overflow-hidden h-40 bg-gray-200">
            <img src="https://picsum.photos/400/300?random=1" alt="Активност" class="w-full h-full object-cover">
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Образовни програми</h3>
        <p class="text-sm text-gray-600 mb-4">Различни образовни активности за развој на вештини и знаења на затворениците</p>
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <i class="fas fa-circle text-xs mr-1"></i> Активно
            </span>
            <span class="text-xs text-gray-500">Крајна рок: 31.12.2026</span>
        </div>
        <div class="flex gap-2">
            <button class="btn-edit flex-1">Уреди</button>
            <button class="btn-danger flex-1">Избриши</button>
        </div>
    </div>

    <!-- Activity Card 2 -->
    <div class="card">
        <div class="relative mb-4 rounded-lg overflow-hidden h-40 bg-gray-200">
            <img src="https://picsum.photos/400/300?random=2" alt="Активност" class="w-full h-full object-cover">
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Спортски активности</h3>
        <p class="text-sm text-gray-600 mb-4">Фудбал, волејбал, тенис и други спортови за физичко здравје</p>
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <i class="fas fa-circle text-xs mr-1"></i> Активно
            </span>
            <span class="text-xs text-gray-500">Крајна рок: 31.12.2026</span>
        </div>
        <div class="flex gap-2">
            <button class="btn-edit flex-1">Уреди</button>
            <button class="btn-danger flex-1">Избриши</button>
        </div>
    </div>

    <!-- Activity Card 3 -->
    <div class="card">
        <div class="relative mb-4 rounded-lg overflow-hidden h-40 bg-gray-200">
            <img src="https://picsum.photos/400/300?random=3" alt="Активност" class="w-full h-full object-cover">
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Уметнички работилници</h3>
        <p class="text-sm text-gray-600 mb-4">Музика, уметност, танц и театар за креативен развој</p>
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                <i class="fas fa-circle text-xs mr-1"></i> Неактивно
            </span>
            <span class="text-xs text-gray-500">Крајна рок: 30.06.2026</span>
        </div>
        <div class="flex gap-2">
            <button class="btn-edit flex-1">Уреди</button>
            <button class="btn-danger flex-1">Избриши</button>
        </div>
    </div>

    <!-- Activity Card 4 -->
    <div class="card">
        <div class="relative mb-4 rounded-lg overflow-hidden h-40 bg-gray-200">
            <img src="https://picsum.photos/400/300?random=4" alt="Активност" class="w-full h-full object-cover">
        </div>
        <h3 class="font-semibold text-gray-800 mb-2">Терапевтски групи</h3>
        <p class="text-sm text-gray-600 mb-4">Психолошка поддршка, советување и однесување терапија</p>
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <i class="fas fa-circle text-xs mr-1"></i> Активно
            </span>
            <span class="text-xs text-gray-500">Крајна рок: 31.12.2026</span>
        </div>
        <div class="flex gap-2">
            <button class="btn-edit flex-1">Уреди</button>
            <button class="btn-danger flex-1">Избриши</button>
        </div>
    </div>
</div>

<!-- PREVIEW SECTION -->
<div class="mt-8 card">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Преглед на слајдер</h3>
    <p class="text-sm text-gray-600 mb-4">Вака ќе изгледаат активностите на почетната страна</p>
    <div class="relative overflow-hidden rounded-lg bg-gray-100 h-64">
        <div class="flex gap-6 overflow-x-auto pb-4">
            <div class="flex-shrink-0 w-80 rounded-xl overflow-hidden shadow-lg">
                <img src="https://picsum.photos/400/300?random=1" alt="Activity" class="w-full h-64 object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/10 backdrop-blur-md border-t border-white/20 text-white">
                    <h3 class="text-xl font-bold">Образовни програми</h3>
                    <p class="text-sm opacity-90">Развој на вештини и знаења</p>
                </div>
            </div>
            <div class="flex-shrink-0 w-80 rounded-xl overflow-hidden shadow-lg">
                <img src="https://picsum.photos/400/300?random=2" alt="Activity" class="w-full h-64 object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/10 backdrop-blur-md border-t border-white/20 text-white">
                    <h3 class="text-xl font-bold">Спортски активности</h3>
                    <p class="text-sm opacity-90">Фудбал, волејбал, тенис</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
