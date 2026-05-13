@extends('admin.layouts.app')

@section('title', 'Рачни Изработки')
@section('page-title', 'Рачни Изработки')
@section('page-subtitle', 'Управување со 4-те категории на изработки')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-3">
    <i class="fas fa-check-circle text-green-500"></i>
    {{ session('success') }}
</div>
@endif

<div class="mb-6">
    <p class="text-gray-500 text-sm">
        Секоја категорија претставува еден дел на страницата „Рачни Изработки". Уредете ги наслов, опис и слика. 
        <strong>„Види повеќе"</strong> на јавната страна води до галеријата филтрирана по таа категорија.
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($categories as $slug => $label)
        @php $hc = $handcrafts[$slug] ?? null; @endphp

        <div class="card hover:shadow-lg transition-all flex flex-col gap-4">

            {{-- Cover image --}}
            <div class="relative rounded-xl overflow-hidden bg-gray-100 h-48">
                @if($hc && $hc->image_url)
                    <img src="{{ \Illuminate\Support\Str::startsWith($hc->image_url, ['http','//']) ? $hc->image_url : asset($hc->image_url) }}"
                         class="w-full h-full object-cover" alt="{{ $hc->title_mk }}" />
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                @endif

                {{-- Published badge --}}
                <div class="absolute top-2 right-2">
                    @if($hc && $hc->is_published)
                        <span class="bg-green-600 text-white px-2 py-1 rounded-full text-xs font-semibold">Активна</span>
                    @else
                        <span class="bg-gray-400 text-white px-2 py-1 rounded-full text-xs font-semibold">Скриена</span>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1 flex flex-col">
                <h3 class="font-bold text-gray-800 text-lg mb-1">
                    {{ $hc ? $hc->title_mk : $label }}
                </h3>
                <p class="text-sm text-gray-400 mb-2 font-mono">{{ $slug }}</p>
                @if($hc && $hc->description_mk)
                    <p class="text-sm text-gray-600 line-clamp-3 flex-1">{{ Str::limit($hc->description_mk, 150) }}</p>
                @else
                    <p class="text-sm text-gray-400 italic">Нема опис.</p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <a href="{{ route('gallery') }}?category={{ $slug }}" target="_blank"
                   class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Прегледај галерија
                </a>
                @if($hc)
                    <a href="{{ route('admin.izrabotki.edit', $slug) }}" class="btn-edit text-xs">
                        <i class="fas fa-edit mr-1"></i> Уреди
                    </a>
                @else
                    <span class="text-xs text-red-400 italic">Запишот не постои – извршете ги миграциите.</span>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection
