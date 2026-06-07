@extends('admin.layouts.app')

@section('title', 'Активности')
@section('page-title', 'Активности')
@section('page-subtitle', 'Управување со активностите на почетната страна')

@section('content')

<!-- ACTION BAR -->
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-3">
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Нова активност
        </button>
        <input type="text" placeholder="Пребарај активности..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
    </div>
    <div class="flex gap-2">
        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <option>Сите</option>
            <option>Активни</option>
            <option>Неактивни</option>
        </select>
    </div>
</div>

<!-- TABLE -->
<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    <input type="checkbox" class="rounded">
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Назив</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Опис</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Слика</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Статус</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Датум</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Дејства</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Образовни програми</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600">Различни образовни активности...</p>
                </td>
                <td class="px-6 py-4">
                    <img src="https://picsum.photos/40/40?random=1" alt="Слика" class="w-10 h-10 rounded">
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Активно
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">15.05.2026</td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>

            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Спортски активности</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600">Фудбал, волејбал и тенис...</p>
                </td>
                <td class="px-6 py-4">
                    <img src="https://picsum.photos/40/40?random=2" alt="Слика" class="w-10 h-10 rounded">
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Активно
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">14.05.2026</td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>

            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Уметнички работилници</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600">Музика, уметност и танц...</p>
                </td>
                <td class="px-6 py-4">
                    <img src="https://picsum.photos/40/40?random=3" alt="Слика" class="w-10 h-10 rounded">
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Неактивно
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">12.05.2026</td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>

            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Терапевтски групи</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600">Психолошка поддршка и советување...</p>
                </td>
                <td class="px-6 py-4">
                    <img src="https://picsum.photos/40/40?random=4" alt="Слика" class="w-10 h-10 rounded">
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Активно
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">13.05.2026</td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div class="mt-6 flex items-center justify-between">
    <p class="text-sm text-gray-600">Приказ 1-4 од 24 активности</p>
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
