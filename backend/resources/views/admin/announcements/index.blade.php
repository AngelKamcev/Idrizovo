@extends('admin.layouts.app')

@section('title', 'Управување со Соопштенија')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Управување со Соопштенија</h1>
        <a href="{{ route('admin.announcements.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Ново Соопштење
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Наслов</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Слика</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Активно</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Датум</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Редослед</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Акции</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $announcement)
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">
                                {{ $announcement->getTranslation('title', 'mk') }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ Str::limit($announcement->getTranslation('content', 'mk'), 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($announcement->getImageUrl())
                                <img src="{{ $announcement->getImageUrl() }}" alt="слика" class="h-10 w-10 object-cover rounded">
                            @else
                                <span class="text-gray-400">Нема слика</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $announcement->is_active ? 'Активно' : 'Неактивно' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $announcement->created_at->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $announcement->sort_order }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-blue-600 hover:text-blue-900">
                                Уреди
                            </a>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Сигурни ли сте?')">
                                    Избриши
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Нема соопштенија
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
