@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Преглед на системот и брз пристап до содржината')

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user?->isAdmin();
    $isReviewer = $user?->isReviewer();
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Активности</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $activitiesCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-list text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Главни активности на почетната</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Соопштенија</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $announcementsCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-newspaper text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Објавени записи во системот</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Галерија</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $galleryCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-images text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Активни слики во галеријата</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Рачни изработки</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $handcraftsCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-hammer text-orange-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Објавени изработки</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Барања за посета</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $visitRequestsCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-check text-sky-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Вкупно поднесени барања</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Одобрени барања</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $approvedRequestsCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Посети со статус approved</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Жалби</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $complaintsCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-comments text-red-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Непроцесирани и процесирани</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Пофалби</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $complimentsCount ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-thumbs-up text-amber-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Сите пристигнати пофалби</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-1">
        <div class="card h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Брзи дејства</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.main-activities.create') }}" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Нова активност
                </a>
                <a href="{{ route('admin.announcements.create') }}" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-file-circle-plus mr-2"></i> Ново соопштение
                </a>
                <a href="{{ route('admin.gallery.create') }}" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-image mr-2"></i> Нова слика
                </a>
                <a href="{{ route('admin.izrabotki') }}" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-hammer mr-2"></i> Уреди изработки
                </a>
                <a href="{{ route('admin.aboutus') }}" class="w-full btn-secondary text-left inline-flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Уреди „За Нас“
                </a>
                <a href="{{ route('admin.visit-schedules') }}" class="w-full btn-secondary text-left inline-flex items-center">
                    <i class="fas fa-clock mr-2"></i> Распоред на посети
                </a>
                @if ($isAdmin)
                    <a href="{{ route('admin.visit-requests') }}" class="w-full btn-secondary text-left inline-flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i> Барања за посета
                    </a>
                    <a href="{{ route('admin.reviewer-dashboard') }}" class="w-full btn-secondary text-left inline-flex items-center">
                        <i class="fas fa-comments mr-2"></i> Жалби и пофалби
                    </a>
                @endif
                @if ($isReviewer)
                    <a href="{{ route('admin.reviewer-dashboard') }}" class="w-full btn-secondary text-left inline-flex items-center">
                        <i class="fas fa-comments mr-2"></i> Жалби и пофалби
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="card h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Статус на системот</h3>
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
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Галерија и содржини</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Синхронизирани</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Рачни изработки</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Активни</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни активности</h3>
            <a href="{{ route('admin.main-activities.index') }}" class="text-blue-600 text-sm hover:underline">Види сите</a>
        </div>
        <div class="space-y-3">
            @forelse ($recentActivities ?? [] as $activity)
                <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate">{{ $activity->title ?? '' }}</p>
                        <p class="text-gray-500 text-xs">{{ $activity->created_at?->diffForHumans() ?? 'Нема датум' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Нема активности за прикажување.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни соопштенија</h3>
            <a href="{{ route('admin.announcements.index') }}" class="text-blue-600 text-sm hover:underline">Види сите</a>
        </div>
        <div class="space-y-3">
            @forelse ($recentAnnouncements ?? [] as $announcement)
                <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate">{{ $announcement->title ?? '' }}</p>
                        <p class="text-gray-500 text-xs">{{ $announcement->published_at?->diffForHumans() ?? $announcement->created_at?->diffForHumans() ?? 'Нема датум' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Нема соопштенија за прикажување.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни барања за посета</h3>
            <a href="{{ route('admin.visit-schedules') }}" class="text-blue-600 text-sm hover:underline">Отвори распоред</a>
        </div>
        <div class="space-y-3">
            @forelse ($recentVisitRequests ?? [] as $request)
                <div class="flex items-start justify-between gap-4 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate">{{ trim(($request->visitor_first_name ?? '') . ' ' . ($request->visitor_last_name ?? '')) }}</p>
                        <p class="text-gray-500 text-xs">{{ $request->visit_date?->format('d.m.Y') ?? 'Без датум' }} · {{ $request->visitSchedule?->group_name ?? 'Без распоред' }}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ $request->status ?? '—' }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">Нема барања за посета.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни рачни изработки</h3>
            <a href="{{ route('admin.izrabotki') }}" class="text-blue-600 text-sm hover:underline">Уреди страница</a>
        </div>
        <div class="space-y-3">
            @forelse ($recentHandcrafts ?? [] as $handcraft)
                <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="w-2 h-2 bg-orange-600 rounded-full mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate">{{ $handcraft->title_mk ?? '' }}</p>
                        <p class="text-gray-500 text-xs">{{ $handcraft->published_at?->diffForHumans() ?? $handcraft->created_at?->diffForHumans() ?? 'Нема датум' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Нема рачни изработки за прикажување.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
