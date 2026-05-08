@extends('admin.layouts.app')

@section('title', 'Пофалби / Жалби')
@section('page-title', 'Пофалби / Жалби')
@section('page-subtitle', 'Пораки што пристигнуваат преку контакт формата')

@section('content')

@if(session('success'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    <div class="card">
        <p class="text-sm text-gray-500">Вкупно пораки</p>
        <div class="mt-2 flex items-end justify-between">
            <h3 class="text-3xl font-bold text-gray-900">{{ $totalComplaints }}</h3>
            <i class="fas fa-inbox text-2xl text-blue-600"></i>
        </div>
    </div>
    <div class="card">
        <p class="text-sm text-gray-500">Нови</p>
        <div class="mt-2 flex items-end justify-between">
            <h3 class="text-3xl font-bold text-gray-900">{{ $newComplaints }}</h3>
            <i class="fas fa-bell text-2xl text-amber-500"></i>
        </div>
    </div>
    <div class="card">
        <p class="text-sm text-gray-500">Прегледани</p>
        <div class="mt-2 flex items-end justify-between">
            <h3 class="text-3xl font-bold text-gray-900">{{ $seenComplaints }}</h3>
            <i class="fas fa-eye text-2xl text-sky-600"></i>
        </div>
    </div>
    <div class="card">
        <p class="text-sm text-gray-500">Затворени</p>
        <div class="mt-2 flex items-end justify-between">
            <h3 class="text-3xl font-bold text-gray-900">{{ $closedComplaints }}</h3>
            <i class="fas fa-check-circle text-2xl text-emerald-600"></i>
        </div>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Пораки од контакт формата</h3>
            <p class="text-sm text-gray-500">Тука стигнуваат пофалбите, жалбите и останатите пораки од јавниот контакт формулар.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[980px]">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Испраќач</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Тип / Наслов</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Контакт</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Порака</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Статус</th>
                    <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Дејства</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($complaints as $complaint)
                    @php
                        $statusClasses = [
                            'new' => 'bg-amber-100 text-amber-800',
                            'seen' => 'bg-sky-100 text-sky-800',
                            'in_progress' => 'bg-violet-100 text-violet-800',
                            'closed' => 'bg-emerald-100 text-emerald-800',
                        ];
                        $statusLabels = [
                            'new' => 'Ново',
                            'seen' => 'Прегледано',
                            'in_progress' => 'Во работа',
                            'closed' => 'Затворено',
                        ];
                    @endphp
                    <tr class="table-row align-top">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-gray-900">{{ $complaint->submitted_by_name }}</p>
                            <p class="text-xs text-gray-500">{{ $complaint->created_at?->format('d.m.Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="font-semibold text-gray-800">{{ $complaint->subject }}</p>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600 space-y-1">
                            <p>{{ $complaint->submitted_by_email ?: 'Нема email' }}</p>
                            <p>{{ $complaint->submitted_by_phone ?: 'Нема телефон' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm text-gray-600 leading-6">{{ \Illuminate\Support\Str::limit($complaint->message, 140) }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$complaint->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$complaint->status] ?? $complaint->status }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <form action="{{ route('admin.complaints.update', $complaint) }}" method="POST" class="flex flex-col gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                                    <option value="new" @selected($complaint->status === 'new')>Ново</option>
                                    <option value="seen" @selected($complaint->status === 'seen')>Прегледано</option>
                                    <option value="in_progress" @selected($complaint->status === 'in_progress')>Во работа</option>
                                    <option value="closed" @selected($complaint->status === 'closed')>Затворено</option>
                                </select>
                                <button class="btn-primary text-sm w-fit">Зачувај</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                            Нема пристигнати пораки.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $complaints->links() }}
    </div>
</div>

@endsection
