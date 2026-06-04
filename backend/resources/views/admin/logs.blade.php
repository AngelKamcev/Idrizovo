@extends('admin.layouts.app')

@section('title', 'Activity Log')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📋 Activity Log</h1>
            <p class="text-sm text-gray-500 mt-1">
                Прикажани {{ count($lines) }} од вкупно {{ $total }} записи
                @if($filter) &mdash; филтер: <strong>{{ $filter }}</strong>@endif
            </p>
        </div>
        <form method="POST" action="{{ route('admin.logs.clear') }}"
              onsubmit="return confirm('Сигурно сакате да го исчистите целиот лог?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                <i class="fa fa-trash"></i> Исчисти лог
            </button>
        </form>
    </div>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('admin.logs') }}" class="flex gap-2">
        <input type="text"
               name="filter"
               value="{{ $filter }}"
               placeholder="Пребарај (корисник, IP, рута, акција...)"
               class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">
            <i class="fa fa-search"></i> Пребарај
        </button>
        @if($filter)
        <a href="{{ route('admin.logs') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center">
            <i class="fa fa-times"></i>
        </a>
        @endif
    </form>

    {{-- Log table --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        @if(count($lines) === 0)
            <div class="text-center py-16 text-gray-400">
                <i class="fa fa-file-alt text-4xl mb-3 block"></i>
                <p class="text-lg font-medium">Нема записи во логот</p>
                @if($filter)<p class="text-sm">Обидете се со поинаков филтер</p>@endif
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 w-40">Датум/Час</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 w-16">Метод</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Рута</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 w-14">Статус</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 w-32">IP</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 w-48">Корисник</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Акција</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($lines as $line)
                        @php
                            // Parse the log line format:
                            // [DATETIME] METHOD /path | STATUS | IP: x.x.x.x | User: Name [role] | Action: ...
                            preg_match('/^\[(.+?)\]\s+(\w+)\s+(\S+)\s+\|\s+(\d+)\s+\|\s+IP:\s+(\S+)\s+\|\s+User:\s+(.+?)(?:\s+\|\s+Action:\s+(.+))?$/', $line, $m);
                            $dt     = $m[1]  ?? '';
                            $method = $m[2]  ?? '';
                            $path   = $m[3]  ?? $line;
                            $status = $m[4]  ?? '';
                            $ip     = $m[5]  ?? '';
                            $user   = $m[6]  ?? '';
                            $action = $m[7]  ?? '';

                            $methodColors = [
                                'GET'    => 'bg-green-100 text-green-700',
                                'POST'   => 'bg-blue-100 text-blue-700',
                                'PATCH'  => 'bg-yellow-100 text-yellow-700',
                                'PUT'    => 'bg-yellow-100 text-yellow-700',
                                'DELETE' => 'bg-red-100 text-red-700',
                            ];
                            $methodClass = $methodColors[$method] ?? 'bg-gray-100 text-gray-600';

                            $statusClass = '';
                            if ($status >= 200 && $status < 300) $statusClass = 'text-green-600 font-semibold';
                            elseif ($status >= 300 && $status < 400) $statusClass = 'text-blue-500';
                            elseif ($status >= 400) $statusClass = 'text-red-600 font-semibold';
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            @if($dt)
                            <td class="px-4 py-3 text-gray-500 text-xs font-mono whitespace-nowrap">{{ $dt }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-bold font-mono {{ $methodClass }}">
                                    {{ $method }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-700 break-all">{{ $path }}</td>
                            <td class="px-4 py-3 text-xs {{ $statusClass }}">{{ $status }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500 font-mono">{{ $ip }}</td>
                            <td class="px-4 py-3 text-xs text-gray-700">{{ $user }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500 italic">{{ $action }}</td>
                            @else
                            <td colspan="7" class="px-4 py-2 font-mono text-xs text-gray-400">{{ $line }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($totalPages > 1)
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
            <span class="text-sm text-gray-500">Страна {{ $page }} / {{ $totalPages }}</span>
            <div class="flex gap-2">
                @if($page > 1)
                <a href="{{ route('admin.logs', ['page' => $page - 1, 'filter' => $filter]) }}"
                   class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    ← Претходна
                </a>
                @endif
                @if($page < $totalPages)
                <a href="{{ route('admin.logs', ['page' => $page + 1, 'filter' => $filter]) }}"
                   class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Следна →
                </a>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>

</div>
@endsection
