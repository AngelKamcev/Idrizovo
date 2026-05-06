@extends('admin.layouts.app')

@section('title', 'Соопштенија')
@section('page-title', 'Соопштенија')
@section('page-subtitle', 'Управување со соопштенијата и новостите')

@section('content')

<!-- ACTION BAR -->
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-3">
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Ново соопштение
        </button>
        <input type="text" placeholder="Пребарај соопштенија..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
    </div>
    <div class="flex gap-2">
        <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <option>Нови соопштенија</option>
            <option>Постари соопштенија</option>
            <option>Сите</option>
        </select>
    </div>
</div>

<!-- TABS -->
<div class="flex gap-4 mb-6 border-b border-gray-200">
    <button class="pb-3 px-1 text-gray-800 font-semibold border-b-2 border-blue-600">
        Нови Соопштенија
    </button>
    <button class="pb-3 px-1 text-gray-600 font-semibold hover:text-gray-800">
        Постари Соопштенија
    </button>
</div>

<!-- TABLE -->
<div class="card overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    <input type="checkbox" class="rounded">
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Наслов</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Содржина</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Датум</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Статус</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Дејства</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">ИНТЕРЕН ОГЛАС за пополнување на работно место</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600 line-clamp-1">Врз основа на член 30 став 1 алинеја 2...</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">06.05.2026</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Објавено
                    </span>
                </td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>

            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Предлог на одлука за избор на кандидати</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600 line-clamp-1">Врз основа на чл.52 ст.1 од Законот...</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">04.05.2026</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Објавено
                    </span>
                </td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>

            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Одлука за поништување на оглас</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600 line-clamp-1">Врз основа на член 31 од Законот...</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">02.05.2026</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Нацрт
                    </span>
                </td>
                <td class="px-6 py-4 flex gap-2">
                    <button class="btn-edit">Уреди</button>
                    <button class="btn-danger text-xs">Избриши</button>
                </td>
            </tr>

            <tr class="table-row">
                <td class="px-6 py-4"><input type="checkbox" class="rounded"></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">Продолжување на рок за прием на документи</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-600 line-clamp-1">КПУ-КПД Идризово го продолжува...</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">01.05.2026</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Објавено
                    </span>
                </td>
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
    <p class="text-sm text-gray-600">Приказ 1-4 од 18 соопштенија</p>
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
