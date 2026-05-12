@extends('layouts.app')

@section('title', 'Активности - Идризово')

@section('content')

<style>
    /* CSS за сокривање на скролбарот, но задржување на функционалноста (за мобилен) */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
</style>

<section class="relative w-full min-h-[600px] h-screen bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('images/hero_main.jpeg') }}');">
    
    <div class="absolute inset-0 bg-white/20"></div>

    <div class="absolute top-1/3 left-8 md:left-24 max-w-md z-10">
        <h3 class="text-white font-semibold text-xl mb-2 drop-shadow-md">
                {{ __('latest_activity') }}
        </h3>
        
        <h1 class="text-[#0E1B2F] text-6xl md:text-7xl font-extrabold mb-4 tracking-tight drop-shadow-sm">
                {{ $activities->first()?->getTranslation('title', app()->getLocale()) ?? __('basketball') }}
        </h1>
        
        <p class="text-[#0E1B2F] text-base md:text-lg mb-8 font-semibold leading-snug pr-4 drop-shadow-md">
                {{ $activities->first()?->getTranslation('description', app()->getLocale()) ?? __('basketball_description') }}
        </p>
        
        <button class="bg-[#2E589E] hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-md shadow-lg transition-all duration-300 transform hover:scale-105">
                {{ __('read_more') }}
        </button>
    </div>
</section>

<section class="md:hidden max-w-md mx-auto py-12">
    <div class="flex justify-between items-center px-5 mb-6">
        <h2 class="text-[#0E1B2F] text-2xl font-extrabold tracking-tight">{{ __('activities') }}</h2>
        <a href="#" class="bg-[#2E589E] hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors shadow-sm">
            {{ __('all_activities') }}
        </a>
    </div>

    <div id="mobile-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-4 px-5 pb-6 hide-scrollbar">
        
        @forelse ($activities as $activity)
            <div class="carousel-item snap-center shrink-0 w-[82vw] h-[400px] relative rounded-2xl overflow-hidden shadow-lg">
                <img src="{{ $activity->getImageUrl() ?? asset('images/bla.jpeg') }}" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner">
                    <h2 class="text-2xl font-bold text-white mb-2 inline-block border-b-2 border-white pb-1">{{ $activity->getTranslation('title', app()->getLocale()) }}</h2>
                    <p class="text-white/90 text-sm leading-snug">{{ $activity->getTranslation('description', app()->getLocale()) }}</p>
                </div>
            </div>
        @empty
            <div class="carousel-item snap-center shrink-0 w-[82vw] h-[400px] relative rounded-2xl overflow-hidden shadow-lg">
                <img src="{{ asset('images/bla.jpeg') }}" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner">
                    <h2 class="text-2xl font-bold text-white mb-2 inline-block border-b-2 border-white pb-1">{{ __('no_activities') }}</h2>
                </div>
            </div>
        @endforelse
    </div>

    <div class="flex justify-center items-center gap-3 mt-2" id="carousel-indicators">
        @for ($i = 0; $i < min($activities->count(), 4); $i++)
            @if ($i === 0)
                <div class="carousel-dot w-10 h-3.5 bg-[#0E1B2F] rounded-full transition-all duration-300"></div>
            @else
                <div class="carousel-dot w-3.5 h-3.5 rounded-full border-[2px] border-[#0E1B2F] transition-all duration-300"></div>
            @endif
        @endfor
    </div>
</section>

<section class="hidden md:block max-w-7xl mx-auto px-4 py-16 font-sans">
    @if ($activities->count() > 0)
    <div class="mb-16">
        <h2 class="text-[#1a2b4b] text-3xl font-bold mb-8">{{ __('most_read_activities') }}</h2>
        <div class="grid grid-cols-4 gap-6">
            @php $firstActivity = $activities->first(); @endphp
            <div class="col-span-2 row-span-2 relative h-[508px] rounded-2xl overflow-hidden group shadow-lg">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('{{ $firstActivity->getImageUrl() ?? asset('images/bla.jpeg') }}');"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                    <h3 class="text-3xl font-bold mb-3">{{ $firstActivity->getTranslation('title', app()->getLocale()) }}</h3>
                    <p class="text-base opacity-90 mb-5">{{ $firstActivity->getTranslation('description', app()->getLocale()) }}</p>
                    <a href="#" class="text-sm uppercase tracking-wider font-bold border-b-2 border-white pb-1">{{ __('read_more') }}</a>
                </div>
            </div>

            @php $otherActivities = $activities->skip(1)->take(4); @endphp
            @foreach ($otherActivities as $activity)
                <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('{{ $activity->getImageUrl() ?? asset('images/bla.jpeg') }}');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h4 class="font-bold text-xl mb-1">{{ $activity->getTranslation('title', app()->getLocale()) }}</h4>
                        <p class="text-xs leading-tight opacity-90 mb-3">{{ Str::limit($activity->getTranslation('description', app()->getLocale()), 50) }}</p>
                        <a href="#" class="text-[11px] uppercase font-bold border-b border-white">{{ __('read_more') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @php $remainingActivities = $activities->skip(5)->take(5); @endphp
    @if ($remainingActivities->count() > 0)
    <div>
        <h2 class="text-[#1a2b4b] text-3xl font-bold mb-8">{{ __('other_activities') }}</h2>
        <div class="grid grid-cols-4 gap-6">
            <div class="col-span-2 grid grid-cols-2 gap-6">
                @php $smallRemaining = $remainingActivities->skip(1)->take(4); @endphp
                @foreach ($smallRemaining as $activity)
                    <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('{{ $activity->getImageUrl() ?? asset('images/bla.jpeg') }}');"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                            <h4 class="font-bold text-xl mb-1">{{ $activity->getTranslation('title', app()->getLocale()) }}</h4>
                            <p class="text-xs leading-tight opacity-90 mb-3">{{ Str::limit($activity->getTranslation('description', app()->getLocale()), 50) }}</p>
                            <a href="#" class="text-[11px] uppercase font-bold border-b border-white">{{ __('read_more') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>

            @php $firstRemaining = $remainingActivities->first(); @endphp
            <div class="col-span-2 row-span-2 relative h-[508px] rounded-2xl overflow-hidden group shadow-lg">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('{{ $firstRemaining->getImageUrl() ?? asset('images/bla.jpeg') }}');"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                    <h3 class="text-3xl font-bold mb-3">{{ $firstRemaining->getTranslation('title', app()->getLocale()) }}</h3>
                    <p class="text-base opacity-90 mb-5">{{ $firstRemaining->getTranslation('description', app()->getLocale()) }}</p>
                    <a href="#" class="text-sm uppercase tracking-wider font-bold border-b-2 border-white pb-1">{{ __('read_more') }}</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carouselItems = document.querySelectorAll('.carousel-item');
        const dots = document.querySelectorAll('.carousel-dot');

        const observerOptions = {
            root: document.getElementById('mobile-carousel'),
            threshold: 0.5 
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const index = Array.from(carouselItems).indexOf(entry.target);
                    
                    dots.forEach((dot, i) => {
                        if (i === index) {
                            dot.className = 'carousel-dot w-10 h-3.5 bg-[#0E1B2F] rounded-full transition-all duration-300';
                        } else {
                            dot.className = 'carousel-dot w-3.5 h-3.5 bg-transparent rounded-full border-[2px] border-[#0E1B2F] transition-all duration-300';
                        }
                    });
                }
            });
        }, observerOptions);

        carouselItems.forEach(item => observer.observe(item));
    });
</script>

@endsection
