@extends('layouts.app')

@section('title', 'Рачни Изработки - Идризово')

@section('content')

@php
    $hb = (string) ($iz['hero_bg'] ?? '');
    if ($hb === '') {
        $izHero = '';
    } elseif (preg_match('#^https?://#i', $hb)) {
        $izHero = $hb;
    } elseif (str_starts_with($hb, '/storage/') || str_starts_with($hb, 'storage/')) {
        $izHero = asset(ltrim($hb, '/'));
    } elseif (preg_match('#^(images|documents)/#', $hb)) {
        $izHero = asset($hb);
    } else {
        $izHero = asset('storage/'.ltrim($hb, '/'));
    }
    $scrollDup = array_merge($iz['scroll_quotes'] ?? [], $iz['scroll_quotes'] ?? []);
    $mcFallbacks = [
        ['title' => __('handmade_card_1_title'), 'body' => __('handmade_card_1_body')],
        ['title' => __('handmade_card_2_title'), 'body' => __('handmade_card_2_body')],
        ['title' => __('handmade_card_3_title'), 'body' => __('handmade_card_3_body')],
    ];
@endphp

<section
    class="hidden md:block relative w-full min-h-screen bg-cover bg-center bg-no-repeat flex items-start justify-start"
    style="background-image: url('{{ $izHero }}')">

    <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-black/10 to-transparent"></div>

    <div class="relative z-10 p-8 md:pt-40 md:pl-64 lg:pl-80">
        <h1 class="text-white text-5xl md:text-7xl lg:text-8xl font-bold leading-tight tracking-tight font-sans">
            {{ __('handmade_heading') }}
        </h1>
        <button type="button" class="mt-6 md:hidden bg-white text-black font-bold px-6 py-3 rounded-full shadow-lg">
            {{ __('read_more') }}
        </button>
    </div>
</section>

<section class="hidden md:block max-w-6xl mx-auto px-4 py-16">
    <div class="border rounded-2xl p-8 md:p-10 bg-white shadow-sm border-black">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">
            {{ !empty($iz['intro_title']) ? $iz['intro_title'] : __('handmade_intro') }}
        </h2>
        <p class="text-gray-700 leading-relaxed">
            {!! nl2br(e($iz['intro_body'] ?? '')) !!}
        </p>
    </div>

    <div class="text-center my-14">
        <h3 class="text-xl md:text-2xl font-semibold italic">
            {{ !empty($iz['quote']) ? $iz['quote'] : __('handmade_quote') }}
        </h3>
    </div>

    <div class="relative overflow-hidden py-10">
        <div class="pointer-events-none absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-white to-transparent z-10"></div>

        <div class="animate-scroll flex gap-5">
            @foreach ($scrollDup as $qText)
                <div class="w-[220px] md:w-[240px] p-3 md:p-4 rounded-xl border border-blue-400/60 bg-[#ffffff] text-gray-800 text-sm md:text-[15px] leading-relaxed shrink-0">
                    {{ $qText }}
                </div>
            @endforeach
        </div>
    </div>
</section>

@foreach ($iz['sections'] ?? [] as $sectionIndex => $section)
    @include('partials.izrabotki_desktop_section', ['section' => $section, 'sectionIndex' => $sectionIndex])
@endforeach

<section class="md:hidden px-6 py-6 space-y-8 bg-gray-100">
    <div class="flex items-center justify-between">
        <h2 class="text-4xl font-bold">{{ __('handmade_items') }}</h2>
        <a href="{{ route('izrabotki') }}" class="bg-[#2E589E] text-white text-sm px-8 py-4 rounded-lg">{{ __('read_more') }}</a>
    </div>

    @foreach ($iz['mobile_cards'] ?? [] as $idx => $card)
        @php
            $fb = $mcFallbacks[$idx] ?? $mcFallbacks[0];
            $cTitle = trim((string) ($card['title'] ?? '')) ?: $fb['title'];
            $cBody = trim((string) ($card['body'] ?? '')) ?: $fb['body'];
            $ci = (string) ($card['image'] ?? '');
            if ($ci === '') {
                $cImg = '';
            } elseif (preg_match('#^https?://#i', $ci)) {
                $cImg = $ci;
            } elseif (str_starts_with($ci, '/storage/') || str_starts_with($ci, 'storage/')) {
                $cImg = asset(ltrim($ci, '/'));
            } elseif (preg_match('#^(images|documents)/#', $ci)) {
                $cImg = asset($ci);
            } else {
                $cImg = asset('storage/'.ltrim($ci, '/'));
            }
        @endphp
        <div class="relative max-w-[360px] mx-auto rounded-2xl overflow-hidden shadow-md transition-all duration-[350ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-[10px] hover:scale-[1.04] hover:shadow-2xl">
            @if ($cImg !== '')
                <img src="{{ $cImg }}" class="w-full h-[380px] object-cover" alt="">
            @else
                <div class="flex h-[380px] w-full items-center justify-center bg-gray-200 text-gray-500 text-sm">{{ __('handmade_items') }}</div>
            @endif
            <div class="absolute bottom-0 w-full bg-black/50 text-white p-4">
                <h3 class="font-semibold">{{ $cTitle }}</h3>
                <p class="text-sm opacity-80">{{ $cBody }}</p>
            </div>
        </div>
    @endforeach
</section>

@endsection
