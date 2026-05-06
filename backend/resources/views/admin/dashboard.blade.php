@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Преглед на системот и управување на содржина')

@section('content')

<!-- STATS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Активности -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Активности</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">24</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-list text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Вкупно на систему</p>
    </div>

    <!-- Соопштенија -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Соопштенија</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">18</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-newspaper text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Последни 30 дена</p>
    </div>

    <!-- Слики (Галерија) -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Слики</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">156</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-images text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Вкупно во галеријата</p>
    </div>

    <!-- Рачни Изработки -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Изработки</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">42</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-hammer text-orange-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Представени производи</p>
    </div>
</div>

<!-- RECENT ACTIVITIES / QUICK ACTIONS -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Actions -->
    <div class="lg:col-span-1">
        <div class="card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Брзи Дејства</h3>
            <div class="space-y-3">
                <button class="w-full btn-primary text-left">
                    <i class="fas fa-plus-circle mr-2"></i> Нова активност
                </button>
                <button class="w-full btn-primary text-left">
                    <i class="fas fa-file-plus mr-2"></i> Ново соопштение
                </button>
                <button class="w-full btn-primary text-left">
                    <i class="fas fa-image mr-2"></i> Нова слика
                </button>
                <button class="w-full btn-secondary text-left">
                    <i class="fas fa-edit mr-2"></i> Уреди страна
                </button>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="lg:col-span-2">
        <div class="card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Статус на Система</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Веб сервер</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Активен</span>
                </div>
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">База на податоци</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Поврзана</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Датотечен систем</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">ОК</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RECENT ITEMS -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Latest Posts -->
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни Соопштенија</h3>
            <a href="#" class="text-blue-600 text-sm hover:underline">Види сите</a>
        </div>
        <div class="space-y-3">
            <div class="flex items-start gap-3 pb-3 border-b border-gray-200">
                <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 flex-shrink-0"></div>
                <div>
                    <p class="text-gray-800 font-medium text-sm">ИНТЕРЕН ОГЛАС за вработување</p>
                    <p class="text-gray-500 text-xs">Пред 2 часа</p>
                </div>
            </div>
            <div class="flex items-start gap-3 pb-3 border-b border-gray-200">
                <div class="w-2 h-2 bg-green-600 rounded-full mt-2 flex-shrink-0"></div>
                <div>
                    <p class="text-gray-800 font-medium text-sm">Одлука за избор на кандидати</p>
                    <p class="text-gray-500 text-xs">Пред 5 часа</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-purple-600 rounded-full mt-2 flex-shrink-0"></div>
                <div>
                    <p class="text-gray-800 font-medium text-sm">Ажурирање на статус</p>
                    <p class="text-gray-500 text-xs">Пред 1 ден</p>
                </div>
            </div>
        </div>
    </div>

    <!-- File Storage -->
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Користена Меморија</h3>
            <span class="text-gray-500 text-sm">2.4 GB / 5 GB</span>
        </div>
        <div class="space-y-4">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 text-sm">Слики (Галерија)</span>
                    <span class="text-gray-600 text-xs">1.2 GB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 50%;"></div>
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 text-sm">Документи</span>
                    <span class="text-gray-600 text-xs">800 MB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 33%;"></div>
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 text-sm">Логови</span>
                    <span class="text-gray-600 text-xs">400 MB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-600 h-2 rounded-full" style="width: 17%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
