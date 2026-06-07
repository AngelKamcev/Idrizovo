@extends('admin.layouts.app')
@section('title', 'Пофалби')
@section('page-title', 'Пофалби')
@section('page-subtitle', 'Позитивни пораки што пристигнуваат преку контакт формата')

@section('content')

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- СТАТИСТИКИ --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @php
        $stats = [
            ['label' => 'Вкупно', 'value' => $totalCompliments, 'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4', 'color' => 'text-blue-500'],
            ['label' => 'Нови', 'value' => $newCompliments, 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => 'text-green-500'],
            ['label' => 'Прегледани', 'value' => $seenCompliments, 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'color' => 'text-sky-500'],
            ['label' => 'Затворени', 'value' => $closedCompliments, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-emerald-500'],
        ];
    @endphp

    @foreach($stats as $s)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">{{ $s['label'] }}</span>
                <svg class="w-4 h-4 {{ $s['color'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                </svg>
            </div>
            <span class="text-3xl font-medium text-gray-900 leading-none">{{ $s['value'] }}</span>
        </div>
    @endforeach
</div>

{{-- ТАБЕЛА --}}
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-900">Позитивни пораки</h3>
        <p class="text-xs text-gray-400 mt-0.5">Пофалби и позитивни коментари од јавниот формулар</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px]">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/60">
                    <th class="px-5 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Испраќач</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Тип / Наслов</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Контакт</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Порака</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Статус</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Дејства</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($compliments as $compliment)
                    @php
                        $chips = [
                            'new'         => ['bg-amber-50 text-amber-700', 'bg-amber-400', 'Ново'],
                            'seen'        => ['bg-sky-50 text-sky-700', 'bg-sky-400', 'Прегледано'],
                            'in_progress' => ['bg-violet-50 text-violet-700', 'bg-violet-400', 'Во работа'],
                            'closed'      => ['bg-emerald-50 text-emerald-700', 'bg-emerald-400', 'Затворено'],
                        ];
                        [$chipClass, $dotClass, $chipLabel] = $chips[$compliment->status] ?? ['bg-gray-100 text-gray-500', 'bg-gray-300', $compliment->status];
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors align-top">

                        {{-- Испраќач --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $compliment->submitted_by_name }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5 tabular-nums">{{ $compliment->created_at?->format('d.m.Y H:i') }}</p>
                        </td>

                        {{-- Тип / Наслов --}}
                        <td class="px-4 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $compliment->subject }}</p>
                        </td>

                        {{-- Контакт --}}
                        <td class="px-4 py-4">
                            <p class="text-xs text-gray-600">{{ $compliment->submitted_by_email ?: '—' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $compliment->submitted_by_phone ?: '—' }}</p>
                        </td>

                        {{-- Порака --}}
                        <td class="px-4 py-4 max-w-[260px]">
                            <p class="text-xs text-gray-500 leading-relaxed">{{ \Illuminate\Support\Str::limit($compliment->message, 130) }}</p>
                        </td>

                        {{-- Статус --}}
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium px-2.5 py-1 rounded-full {{ $chipClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                {{ $chipLabel }}
                            </span>
                        </td>

                        {{-- Дејства --}}
                        <td class="px-4 py-4">
                            <div class="flex flex-col gap-2 min-w-[140px]">
                                {{-- Брзо означување како прочитано --}}
                                @if($compliment->status === 'new')
                                    <form action="{{ route('admin.compliments.update', $compliment) }}" method="POST" class="contents">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="seen">
                                        <button type="submit"
                                            class="w-full py-1.5 bg-sky-50 text-sky-700 text-xs font-medium border border-sky-200 rounded-lg hover:bg-sky-100 active:scale-[0.98] transition-all flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Прочитај
                                        </button>
                                    </form>
                                @endif

                                {{-- Dropdown за менување статус --}}
                                <form action="{{ route('admin.compliments.update', $compliment) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <div class="relative flex-1">
                                        <select name="status"
                                            class="w-full px-3 py-1.5 pr-8 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-700
                                                   appearance-none focus:outline-none focus:border-gray-400 transition-colors cursor-pointer">
                                            <option value="new"         @selected($compliment->status === 'new')>Ново</option>
                                            <option value="seen"        @selected($compliment->status === 'seen')>Прегледано</option>
                                            <option value="in_progress" @selected($compliment->status === 'in_progress')>Во работа</option>
                                            <option value="closed"      @selected($compliment->status === 'closed')>Затворено</option>
                                        </select>
                                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
                                    </div>
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-gray-900 text-white text-xs font-medium rounded-lg hover:bg-gray-700 active:scale-[0.98] transition-all flex-shrink-0">
                                        ✓
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center text-sm text-gray-300">
                            Нема пристигнати пофалби.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($compliments->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $compliments->links() }}
        </div>
    @endif
</div>

@endsection
