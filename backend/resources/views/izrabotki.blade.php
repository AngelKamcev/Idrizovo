@extends('layouts.app')

@section('title', 'Рачни Изработки - Идризово')

@section('content')

{{-- HERO --}}
<section
    class="hidden md:block relative w-full min-h-screen bg-cover bg-center bg-no-repeat flex items-start justify-start"
    style="background-image: url('{{ asset('images/ChatGPT Image Apr 28, 2026, 10_45_13 PM.png') }}')">
    <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-black/10 to-transparent"></div>
    <div class="relative z-10 p-8 md:pt-40 md:pl-64 lg:pl-80">
        <h1 class="text-white text-5xl md:text-7xl lg:text-8xl font-bold leading-tight tracking-tight font-sans">
            {{ __('handmade_heading') }}
        </h1>
    </div>
</section>

{{-- INTRO + SCROLLING QUOTES --}}
<section class="hidden md:block max-w-6xl mx-auto px-4 py-16">
    <div class="border rounded-2xl p-8 md:p-10 bg-white shadow-sm border-black">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ __('handmade_intro') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            Во рамките на КПД Идризово, осудениците активно учествуваат во работилници каде што изработуваат различни рачни предмети. Овие активности придонесуваат кон развој на нови вештини, креативност и подготовка за независен живот по издржувањето на казната.
        </p>
    </div>
    <div class="text-center my-14">
        <h3 class="text-xl md:text-2xl font-semibold italic">{{ __('handmade_quote') }}</h3>
    </div>
    <div class="relative overflow-hidden py-10">
        <div class="pointer-events-none absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-white to-transparent z-10"></div>
        <div class="animate-scroll flex gap-5">
            @foreach(array_fill(0, 16, '„Во секој бод и секој засек има дел од мојата тишина. Работилницата ми е терапија.') as $quote)
            <div class="w-[220px] md:w-[240px] p-3 md:p-4 rounded-xl border border-blue-400/60 bg-white text-gray-800 text-sm md:text-[15px] leading-relaxed shrink-0">{{ $quote }}</div>
            @endforeach
        </div>
    </div>
</section>

{{-- CATEGORY SECTIONS (desktop) --}}
@foreach(array_keys($categories) as $index => $slug)
    @php
        $hc  = $handcrafts[$slug] ?? null;
        $title = $hc ? $hc->title_mk : ($categories[$slug] ?? $slug);
        $desc  = $hc ? $hc->description_mk : '';
        $img   = ($hc && $hc->image_url)
            ? (\Illuminate\Support\Str::startsWith($hc->image_url, ['http','//']) ? $hc->image_url : asset($hc->image_url))
            : 'https://picsum.photos/500/400?' . ($index + 1);
        $galleryUrl = route('gallery') . '?category=' . $slug;
        $isEven = ($index % 2 === 0);
    @endphp

    <section class="py-16 hidden md:block">
        <div class="max-w-7xl mx-auto px-6 flex {{ $isEven ? 'flex-row' : 'flex-row-reverse' }} items-center gap-12">

            {{-- IMAGE STACK --}}
            <div class="flex items-center">
                <div class="relative z-10">
                    <img src="{{ $img }}" class="w-[420px] h-[420px] object-cover rounded-2xl shadow-lg" alt="{{ $title }}" />
                </div>
                <div class="flex -ml-16">
                    @for($s = 1; $s <= 4; $s++)
                    <div class="{{ $s > 1 ? 'group relative -ml-10' : 'group relative' }}">
                        <img src="{{ 'https://picsum.photos/500/400?' . ($index * 10 + $s) }}"
                             class="w-[70px] h-[420px] object-cover rounded-xl shadow-md transition-all duration-500 group-hover:w-[420px] group-hover:ml-4 group-hover:z-50" />
                    </div>
                    @endfor
                </div>
            </div>

            {{-- TEXT --}}
            <div class="max-w-lg">
                <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>
                <p class="text-gray-700 leading-relaxed mb-6">{{ $desc }}</p>
                <a href="{{ $galleryUrl }}" class="inline-block bg-[#0E1B2F] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                    {{ __('view_more') }}
                </a>
            </div>
        </div>
    </section>
@endforeach

{{-- MOBILE CARDS --}}
<section class="md:hidden px-6 py-6 space-y-8 bg-gray-100">
    <div class="flex items-center justify-between">
        <h2 class="text-4xl font-bold">{{ __('handmade_items') }}</h2>
    </div>
    @foreach(array_keys($categories) as $index => $slug)
        @php
            $hc  = $handcrafts[$slug] ?? null;
            $title = $hc ? $hc->title_mk : ($categories[$slug] ?? $slug);
            $img   = ($hc && $hc->image_url)
                ? (\Illuminate\Support\Str::startsWith($hc->image_url, ['http','//']) ? $hc->image_url : asset($hc->image_url))
                : 'https://picsum.photos/500/400?' . ($index + 1);
            $galleryUrl = route('gallery') . '?category=' . $slug;
        @endphp
        <a href="{{ $galleryUrl }}"
           class="block relative max-w-[360px] mx-auto rounded-2xl overflow-hidden shadow-md transition-all duration-[350ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-[10px] hover:scale-[1.04] hover:shadow-2xl">
            <img src="{{ $img }}" class="w-full h-[380px] object-cover" alt="{{ $title }}">
            <div class="absolute bottom-0 w-full bg-black/50 text-white p-4">
                <h3 class="font-semibold">{{ $title }}</h3>
                <p class="text-sm opacity-80">{{ __('view_more') }}</p>
            </div>
        </a>
    @endforeach
</section>

@endsection
