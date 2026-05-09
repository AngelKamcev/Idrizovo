@extends('layouts.app')

@section('title', __('activities'))

@section('content')
<div class="py-12 px-4 md:px-8 lg:px-16">
    <!-- Page Header -->
    <div class="mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ __('activities') }}</h1>
        <p class="text-lg text-gray-600">{{ __('Explore our institutional activities and programs') }}</p>
    </div>

    <!-- Language Switcher -->
    <div class="flex justify-center mb-8">
        @component('components.language-switcher') @endcomponent
    </div>

    <!-- Activities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($activities as $activity)
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden">
                <!-- Activity Image -->
                @if($activity->image_url)
                    <div class="h-48 md:h-56 overflow-hidden bg-gray-200">
                        <img src="{{ $activity->image_url }}" 
                             alt="{{ $activity->getTranslation('title', app()->getLocale()) }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                @endif

                <!-- Activity Content -->
                <div class="p-6">
                    <!-- Icon -->
                    @if($activity->icon)
                        <div class="text-3xl mb-3">
                            <i class="{{ $activity->icon }}"></i>
                        </div>
                    @endif

                    <!-- Title (Translated) -->
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                        {{ $activity->getTranslation('title', app()->getLocale()) }}
                    </h3>

                    <!-- Description (Translated) -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $activity->getTranslation('description', app()->getLocale()) }}
                    </p>

                    <!-- Available Languages -->
                    <div class="flex gap-2 mb-4 flex-wrap">
                        @foreach(['mk', 'en', 'sq'] as $lang)
                            @if($activity->hasTranslation('title', $lang))
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                    @switch($lang)
                                        @case('mk')
                                            🇲🇰
                                        @break
                                        @case('en')
                                            🇬🇧
                                        @break
                                        @case('sq')
                                            🇦🇱
                                        @break
                                    @endswitch
                                    {{ strtoupper($lang) }}
                                </span>
                            @endif
                        @endforeach
                    </div>

                    <!-- Read More Button -->
                    <a href="#" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm">
                        {{ __('Learn More') }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-12">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('no_results') }}</h3>
                <p class="text-gray-600">{{ __('No activities available at the moment.') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($activities->hasPages())
        <div class="mt-12">
            {{ $activities->links() }}
        </div>
    @endif
</div>
@endsection
