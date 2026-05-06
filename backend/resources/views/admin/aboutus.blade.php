@extends('admin.layouts.app')

@section('title', 'За Нас')
@section('page-title', 'За Нас')
@section('page-subtitle', 'Управување со содржина на страната "За нас"')

@section('content')

<!-- TABS -->
<div class="flex gap-4 mb-6 border-b border-gray-200">
    <button class="pb-3 px-1 text-gray-800 font-semibold border-b-2 border-blue-600">
        Основни информации
    </button>
    <button class="pb-3 px-1 text-gray-600 font-semibold hover:text-gray-800">
        Одговорни Лица
    </button>
    <button class="pb-3 px-1 text-gray-600 font-semibold hover:text-gray-800">
        Миција и Визија
    </button>
</div>

<!-- CONTENT SECTION -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- MAIN EDITOR -->
    <div class="lg:col-span-2">
        <div class="card mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Опис на Установа</h3>
            <textarea class="w-full h-40 p-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-sans" placeholder="Напишете опис на установата...">Казнено-поправна установа КПУ-КПД Идризово е една од главните установи за извршување на казни лишување од слобода во Република Македонија. Установата е основана со цел да обезбеди хуманен и безбеден начин на извршување на казнени санкции во согласност со национално и меѓународно право.

Основната улога на установата е да обезбеди сигурност и редослед, да ги заштити правата на затворениците и да придонесе во нивната ресоцијализација и подготовка за враќање во општеството.</textarea>
            <div class="mt-4 flex gap-3">
                <button class="btn-primary">Зачувај промени</button>
                <button class="btn-secondary">Отповикај</button>
            </div>
        </div>

        <!-- MISSION & VISION -->
        <div class="card mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Миција и Визија</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Миција</label>
                    <textarea class="w-full h-24 p-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-sans" placeholder="Напишете миција...">Да обезбедиме безбедна, хумана и ефикасна казнено-поправна услуга што придонесува во ресоцијализација на затворениците и намалување на повторно криминално однесување.</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Визија</label>
                    <textarea class="w-full h-24 p-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-sans" placeholder="Напишете визија...">Казнено-поправна установа што е препозната по своята посветеност на човечност, правди и развој на затворениците во зајакнување на Правната држава и мирот во заедницата.</textarea>
                </div>
            </div>
            <div class="mt-4 flex gap-3">
                <button class="btn-primary">Зачувај промени</button>
                <button class="btn-secondary">Отповикај</button>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div>
        <div class="card mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Брзи Информации</h3>
            <div class="space-y-4 text-sm">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Основна година</label>
                    <input type="text" value="1998" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Вкупен број местa</label>
                    <input type="number" value="450" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Адреса</label>
                    <input type="text" value="Идризово, Скопје" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Слика (лого)</h3>
            <div class="mb-4 p-4 border-2 border-dashed border-gray-300 rounded-lg text-center">
                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                <p class="text-sm text-gray-600">Кликни или повлечи слика</p>
            </div>
            <button class="w-full btn-secondary text-sm">Промени слика</button>
        </div>
    </div>
</div>

<!-- RESPONSIBLE PEOPLE SECTION -->
<div class="mt-8 card">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Одговорни Лица</h3>
        <button class="btn-primary text-sm">
            <i class="fas fa-plus mr-2"></i> Додади лице
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Име</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Позиција</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Телефон</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Дејства</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">Драган Стевовски</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600">Директор</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600">+389 2 123 4567</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-blue-600 text-sm">director@kpu.mk</p>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <button class="btn-edit text-xs">Уреди</button>
                        <button class="btn-danger text-xs">Избриши</button>
                    </td>
                </tr>

                <tr class="table-row">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">Марина Петровска</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600">Заместник директор</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600">+389 2 123 4568</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-blue-600 text-sm">zamestnik@kpu.mk</p>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <button class="btn-edit text-xs">Уреди</button>
                        <button class="btn-danger text-xs">Избриши</button>
                    </td>
                </tr>

                <tr class="table-row">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">Јордан Ацкоски</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600">Шеф на охрана</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600">+389 2 123 4569</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-blue-600 text-sm">ohrana@kpu.mk</p>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <button class="btn-edit text-xs">Уреди</button>
                        <button class="btn-danger text-xs">Избриши</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
