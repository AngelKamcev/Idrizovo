@extends('admin.layouts.app')

@section('title', 'Активности')
@section('page-title', 'Активности')
@section('page-subtitle', 'Управување со активностите на почетната страна')

@section('content')

<!-- ACTION BAR -->
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-3">
        <a href="{{ route('admin.main-activities.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Нова активност
        </a>
        <input type="text" id="search-input" placeholder="Пребарај активности..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
    </div>
    <div class="flex gap-2">
        <select id="status-filter" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <option value="">Сите</option>
            <option value="1">Активни</option>
            <option value="0">Неактивни</option>
        </select>
    </div>
</div>

<!-- SUCCESS MESSAGE -->
@if ($message = Session::get('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex gap-3">
        <i class="fas fa-check-circle text-green-600 text-xl flex-shrink-0 mt-0.5"></i>
        <div class="text-sm">
            <p class="font-semibold text-green-900">Успешно</p>
            <p class="text-green-800">{{ $message }}</p>
        </div>
    </div>
@endif

<!-- TABLE -->
<div class="card overflow-hidden">
    @if($activities->count())
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <input type="checkbox" class="rounded" id="select-all">
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
                @foreach($activities as $activity)
                    <tr class="table-row activity-row">
                        <td class="px-6 py-4"><input type="checkbox" class="rounded activity-checkbox"></td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-800">{{ $activity->getTranslation('title', 'mk') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ Str::limit($activity->getTranslation('description', 'mk'), 50) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($activity->getImageUrl())
                                <img src="{{ $activity->getImageUrl() }}" alt="Слика" class="w-10 h-10 rounded object-cover">
                            @else
                                <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-xs"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($activity->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle text-xs mr-1"></i> Активно
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-circle text-xs mr-1"></i> Неактивно
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $activity->created_at->format('d.m.Y') }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.main-activities.edit', $activity) }}" class="btn-edit">Уреди</a>
                            <form action="{{ route('admin.main-activities.destroy', $activity) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger text-xs" onclick="return confirm('Дали сте сигурни?')">Избриши</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="mt-6 flex items-center justify-between px-6 pb-6">
            <p class="text-sm text-gray-600">Приказ од {{ ($activities->currentPage()-1) * $activities->perPage() + 1 }} до {{ min($activities->currentPage() * $activities->perPage(), $activities->total()) }} од {{ $activities->total() }} активности</p>
            <div>
                {{ $activities->links() }}
            </div>
        </div>
    @else
        <div class="p-12 text-center">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg">Нема активности</p>
            <a href="{{ route('admin.main-activities.create') }}" class="btn-primary mt-4 inline-block">
                <i class="fas fa-plus mr-2"></i> Нова активност
            </a>
        </div>
    @endif
</div>

@endsection
