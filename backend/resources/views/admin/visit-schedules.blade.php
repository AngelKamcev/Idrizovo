@extends('admin.layouts.app')

@section('title', 'Распоред на посети')
@section('page-title', 'Распоред на посети')
@section('page-subtitle', 'Управување со групите и термините за посета преку портирница')

@section('content')

@if(session('success'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="card xl:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Додај нова група</h3>
        <form method="POST" action="{{ route('admin.visit-schedules.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Име на група</label>
                <input type="text" name="group_name" value="{{ old('group_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" placeholder="1 Група" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Денови</label>
                <input type="text" name="days_label" value="{{ old('days_label') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" placeholder="Понеделник - Четврток" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Време</label>
                <input type="text" name="time_range" value="{{ old('time_range') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" placeholder="08:30-09:30" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Редослед</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" min="0">
            </div>
            <label class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" checked>
                Активна група
            </label>
            <button class="btn-primary w-full">Зачувај група</button>
        </form>
    </div>

    <div class="card xl:col-span-2 overflow-hidden">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Постоечки групи</h3>
                <p class="text-sm text-gray-500">Овие податоци се прикажуваат на контакт страната.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[840px]">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Група</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Денови</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Време</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Активна</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Дејства</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($visitSchedules as $visitSchedule)
                        <tr class="table-row align-top">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900">{{ $visitSchedule->group_name }}</p>
                                <p class="text-xs text-gray-500">Редослед: {{ $visitSchedule->sort_order }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $visitSchedule->days_label }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $visitSchedule->time_range }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $visitSchedule->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $visitSchedule->is_active ? 'Да' : 'Не' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="space-y-3">
                                    <form method="POST" action="{{ route('admin.visit-schedules.update', $visitSchedule) }}" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="group_name" value="{{ old('group_name', $visitSchedule->group_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                                        <input type="text" name="days_label" value="{{ old('days_label', $visitSchedule->days_label) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                                        <input type="text" name="time_range" value="{{ old('time_range', $visitSchedule->time_range) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                                        <input type="number" name="sort_order" value="{{ old('sort_order', $visitSchedule->sort_order) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" min="0">
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked($visitSchedule->is_active)>
                                            Активна
                                        </label>
                                        <button class="btn-edit text-sm w-fit">Ажурирај</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.visit-schedules.destroy', $visitSchedule) }}" onsubmit="return confirm('Дали си сигурен дека сакаш да ја избришеш групата?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger text-sm">Избриши</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                Нема внесени групи.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
