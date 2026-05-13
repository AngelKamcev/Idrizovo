@extends('layouts.app')

@section('title', 'Галерија - Идризово')

@section('content')

<div class="bg-white md:bg-gradient-to-b md:from-[#FFFFFF] md:via-[#6A92D4] md:to-[#FFFFFF] min-h-screen">

  {{-- ── DESKTOP ── --}}
  <div class="hidden md:block max-w-5xl mx-auto px-6 py-8 relative">
    <div class="max-w-5xl mx-auto px-2 md:px-4 py-8 relative">

      {{-- Back + heading --}}
      <div class="flex items-end gap-5 mb-10">
        <div class="-ml-15 -mt-5">
          <a href="{{ $categorySlug ? route('izrabotki') : route('index') }}"
             class="w-8 h-10 flex items-center justify-start text-xl text-[#0e1b38] hover:opacity-70 transition">
            <i class="fa-solid fa-chevron-left text-3xl"></i>
          </a>
        </div>
        <div class="pb-1">
          <h1 class="text-2xl md:text-3xl font-bold text-[#0e1b38]">
            @if($categorySlug && $activeCategory)
              {{ $activeCategory->title_mk }}
            @else
              {{ __('gallery') }}
            @endif
          </h1>
          @if($categorySlug)
            <p class="text-sm text-gray-500 mt-1">
              Рачни Изработки › {{ $categories[$categorySlug] ?? $categorySlug }}
            </p>
          @endif
        </div>
      </div>

      {{-- Category filter tabs --}}
      <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('gallery') }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                  {{ !$categorySlug ? 'bg-[#0E1B2F] text-white border-[#0E1B2F]' : 'border-gray-300 text-gray-600 hover:border-[#0E1B2F]' }}">
          Сите
        </a>
        @foreach($categories as $slug => $label)
          <a href="{{ route('gallery') }}?category={{ $slug }}"
             class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                    {{ $categorySlug === $slug ? 'bg-[#0E1B2F] text-white border-[#0E1B2F]' : 'border-gray-300 text-gray-600 hover:border-[#0E1B2F]' }}">
            {{ $label }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- Image grid --}}
    @if($images->count())
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($images as $image)
          @php
            $src = \Illuminate\Support\Str::startsWith($image->image_url, ['http','//'])
                ? $image->image_url : asset($image->image_url);
            $desc = app()->getLocale() === 'en'
                ? ($image->description_en ?? $image->description_mk)
                : (app()->getLocale() === 'al'
                    ? ($image->description_al ?? $image->description_mk)
                    : $image->description_mk);
          @endphp
          <div class="bg-[#8fa8d7]/80 rounded-2xl overflow-hidden shadow-lg backdrop-blur-sm transform transition duration-300 hover:scale-105 hover:z-10">
            <img src="{{ $src }}" class="w-full h-72 object-cover" alt="{{ $desc }}" />
            @if($desc)
            <div class="p-5">
              <p class="text-white/90 text-sm leading-6">{{ $desc }}</p>
            </div>
            @endif
          </div>
        @endforeach
      </div>

      @if($images->hasPages())
        <div class="mt-10">{{ $images->appends(['category' => $categorySlug])->links() }}</div>
      @endif

    @else
      <div class="text-center py-24 text-gray-400">
        <i class="fas fa-images text-5xl mb-4 block"></i>
        <p class="text-lg">Нема слики во оваа категорија.</p>
        @if($categorySlug)
          <a href="{{ route('gallery') }}" class="mt-4 inline-block text-[#0E1B2F] underline text-sm">
            ← Назад кон сите слики
          </a>
        @endif
      </div>
    @endif
  </div>

  {{-- ── MOBILE ── --}}
  <div class="block md:hidden min-h-screen bg-white p-4 -mb-20">
    <div class="flex flex-col gap-4">

      @if($categorySlug)
        <a href="{{ route('gallery') }}" class="flex items-center gap-2 text-[#0e1b38] font-medium text-sm">
          <i class="fa-solid fa-chevron-left"></i> Назад
        </a>
      @endif

      <h2 class="text-4xl font-bold text-black px-2 pb-2">
        @if($categorySlug && $activeCategory)
          {{ $activeCategory->title_mk }}
        @else
          {{ __('gallery') }}
        @endif
      </h2>

      @if(!$categorySlug)
        {{-- Show category tiles --}}
        <div class="flex flex-col gap-3">
          @foreach($categories as $slug => $label)
            @php $i = $loop->index; @endphp
            <a href="{{ route('gallery') }}?category={{ $slug }}"
               class="group relative h-32 w-full overflow-hidden rounded-2xl bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm"
               style="background-image: url('https://picsum.photos/id/{{ 100 + $i }}/400/200')">
              <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
                <p class="text-center text-white font-bold text-xs uppercase tracking-widest">{{ $label }}</p>
              </div>
            </a>
          @endforeach
        </div>

      @else
        {{-- Show images for selected category --}}
        <div class="flex flex-col gap-4">
          @forelse($images as $image)
            @php
              $src = \Illuminate\Support\Str::startsWith($image->image_url, ['http','//'])
                  ? $image->image_url : asset($image->image_url);
              $desc = app()->getLocale() === 'en'
                  ? ($image->description_en ?? $image->description_mk)
                  : (app()->getLocale() === 'al'
                      ? ($image->description_al ?? $image->description_mk)
                      : $image->description_mk);
            @endphp
            <div class="rounded-2xl overflow-hidden shadow-md">
              <img src="{{ $src }}" class="w-full h-64 object-cover" />
              @if($desc)
              <div class="p-3 bg-white">
                <p class="text-sm text-gray-600">{{ $desc }}</p>
              </div>
              @endif
            </div>
          @empty
            <div class="text-center py-16 text-gray-400">
              <p>Нема слики во оваа категорија.</p>
              <a href="{{ route('gallery') }}" class="mt-2 inline-block text-[#0E1B2F] underline text-sm">← Назад</a>
            </div>
          @endforelse
        </div>

        @if($images->hasPages())
          <div class="mt-6">{{ $images->appends(['category' => $categorySlug])->links() }}</div>
        @endif
      @endif

      {{-- Accordion strip (only on main gallery, no filter) --}}
      @if(!$categorySlug)
      <div class="flex h-72 w-full gap-2 mt-2">
        @foreach($categories as $slug => $label)
          @php $i = $loop->index; @endphp
          <a href="{{ route('gallery') }}?category={{ $slug }}"
             class="{{ $i === 0 ? 'flex-[4]' : 'flex-1' }} hover:flex-[4] transition-all duration-500 ease-in-out bg-cover bg-center rounded-2xl cursor-pointer {{ $i > 0 ? 'border-l border-white/10' : '' }}"
             style="background-image: url('https://picsum.photos/id/{{ 110 + $i }}/200/400')"></a>
        @endforeach
      </div>
      @endif

    </div>
  </div>

</div>
@endsection
