@extends('layouts.app')

@section('title', $section['title'] . ' - Идризово')

@section('content')

@php
    $resolveUrl = function (?string $u): string {
        $u = (string) $u;
        if ($u === '') return '';
        if (preg_match('/^https?:\/\//i', $u)) return $u;
        if (str_starts_with($u, '/storage/') || str_starts_with($u, 'storage/')) return asset(ltrim($u, '/'));
        if (preg_match('#^(images|documents)/#', $u)) return asset($u);
        return asset('storage/'.ltrim($u, '/'));
    };

    $strips = $section['strip_images'] ?? [];
    $strips = array_values(array_filter($strips, fn ($s) => is_string($s) && $s !== ''));
@endphp

{{-- Hero --}}
<section class="bg-[#f5f3ef] border-b border-[#ddd9d0] py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-6">

        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('izrabotki') }}"
               class="inline-flex items-center gap-1.5 text-[#888] hover:text-[#0E1B2F] text-xs font-medium tracking-widest uppercase transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Назад на Рачни Изработки
            </a>
            <span class="text-[#ccc]">/</span>
            <span class="inline-flex items-center gap-1.5 border border-[#0E1B2F]/20 text-[#0E1B2F]/60 text-xs font-medium tracking-widest uppercase px-3 py-1">
                Работилница · КПУ Идризово
            </span>
        </div>

        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-normal text-[#0E1B2F] leading-tight tracking-tight mb-4"
                style="font-family: Georgia, serif;">
                {{ $section['title'] }}
            </h1>
            <div class="w-10 h-0.5 bg-[#c9a84c] mb-6"></div>
            <p class="text-base text-[#555] leading-relaxed max-w-xl">
                {!! nl2br(e($section['body'])) !!}
            </p>
        </div>

        <div class="flex items-center gap-6 mt-8 pt-6 border-t border-[#ddd9d0]">
            <div class="flex items-center gap-1.5 text-[11px] text-[#888] tracking-widest uppercase">
                <svg class="w-3.5 h-3.5 text-[#c9a84c]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ count($strips) }} {{ count($strips) === 1 ? 'слика' : 'слики' }}
            </div>
            <div class="flex items-center gap-1.5 text-[11px] text-[#888] tracking-widest uppercase">
                <svg class="w-3.5 h-3.5 text-[#c9a84c]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Идризово
            </div>
        </div>

    </div>
</section>

{{-- Main Image --}}
@if (!empty($section['main_image']))
<section class="bg-[#ede9e0] py-8">
    <div class="max-w-6xl mx-auto px-6">
        <img src="{{ $resolveUrl($section['main_image']) }}"
             alt="{{ $section['title'] }}"
             class="w-full h-auto" />
    </div>
</section>
@endif

{{-- Gallery --}}
@if (count($strips) > 0)
<section class="bg-[#f5f3ef] py-10">
    <div class="max-w-6xl mx-auto px-6">

        <div class="flex items-center gap-3 mb-6">
            <span class="text-[10px] font-semibold tracking-[0.12em] uppercase text-[#0E1B2F]">Галерија</span>
            <span class="text-[10px] text-[#a09a8e] tracking-wide">{{ str_pad(count($strips), 2, '0', STR_PAD_LEFT) }} слики</span>
            <div class="flex-1 h-px bg-[#d4cfc4]"></div>
        </div>

        {{-- Desktop grid --}}
        <div class="hidden md:grid grid-cols-3 gap-1.5">
            @foreach ($strips as $i => $image)
            <div class="group relative overflow-hidden bg-[#d4cfc4] {{ $i === 0 ? 'col-span-2 aspect-video' : 'aspect-[4/3]' }}">
                <img src="{{ $resolveUrl($image) }}"
                     alt=""
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                <button type="button"
                        class="openModal absolute inset-0 bg-[#0E1B2F]/0 group-hover:bg-[#0E1B2F]/50 flex items-center justify-center transition-all duration-300"
                        data-image="{{ $resolveUrl($image) }}"
                        aria-label="Прикажи поголема">
                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </button>
                <span class="absolute bottom-2 left-3 text-[10px] text-white/30 font-medium tracking-wider">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- Mobile carousel --}}
        <div class="md:hidden overflow-x-auto pb-4">
            <div class="flex gap-2">
                @foreach ($strips as $i => $image)
                <div class="flex-shrink-0 w-56 aspect-[4/3] relative overflow-hidden bg-[#d4cfc4]">
                    <img src="{{ $resolveUrl($image) }}"
                         alt=""
                         class="w-full h-full object-cover" />
                    <button type="button"
                            class="openModal absolute inset-0 bg-[#0E1B2F]/0 hover:bg-[#0E1B2F]/50 flex items-center justify-center transition-all"
                            data-image="{{ $resolveUrl($image) }}"
                            aria-label="Прикажи поголема">
                        <svg class="w-6 h-6 text-white opacity-0 hover:opacity-100 transition-opacity"
                             fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </button>
                    <span class="absolute bottom-2 left-3 text-[10px] text-white/30 font-medium">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- Modal --}}
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <img id="modalImage" src="" alt="" class="w-full h-auto" />
        <button id="closeModal" type="button"
                class="absolute top-4 right-4 text-white/60 hover:text-white transition"
                aria-label="Затвори">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script>
document.querySelectorAll('.openModal').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('modalImage').src = btn.getAttribute('data-image');
        const m = document.getElementById('imageModal');
        m.classList.remove('hidden');
        m.classList.add('flex');
    });
});
function closeModal() {
    const m = document.getElementById('imageModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
}
document.getElementById('closeModal').addEventListener('click', closeModal);
document.getElementById('imageModal').addEventListener('click', e => {
    if (e.target.id === 'imageModal') closeModal();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
</script>
@endif

{{-- Back --}}
<div class=" py-6 flex items-center justify-center">
    <a href="{{ route('izrabotki') }}"
       class="inline-flex items-center gap-2 border border-[#c9a84c]/30 text-[#c9a84c] hover:border-[#c9a84c] text-xs font-medium tracking-widest uppercase px-6 py-3 transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Назад на Рачни Изработки
    </a>
</div>

@endsection