<!-- Language Switcher Dropdown -->
<div class="relative group">
    <!-- Current Language Display -->
    <button class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-all text-sm font-medium text-gray-700">
        <i class="fas fa-globe"></i>
        <span>{{ strtoupper(app()->getLocale()) }}</span>
        <i class="fas fa-chevron-down text-xs"></i>
    </button>

    <!-- Dropdown Menu -->
    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 z-50">
        @foreach(['mk', 'en', 'sq'] as $localeCode)
            @php
                $localeName = get_locale_name($localeCode);
                $emoji = get_locale_emoji($localeCode);
                $isActive = is_locale_active($localeCode);
                $url = localized_url($localeCode);
            @endphp
            <a href="{{ $url }}"
               class="flex items-center gap-3 px-4 py-3 hover:bg-blue-50 transition-colors {{ $isActive ? 'bg-blue-50 border-l-4 border-blue-500 text-blue-600 font-semibold' : 'text-gray-700' }}"
               title="{{ $localeName }}">
                <span class="text-lg">{{ $emoji }}</span>
                <div class="flex flex-col">
                    <span class="font-medium">{{ $localeName }}</span>
                    <span class="text-xs text-gray-500">{{ strtoupper($localeCode) }}</span>
                </div>
                @if($isActive)
                    <span class="ml-auto">
                        <i class="fas fa-check text-blue-500"></i>
                    </span>
                @endif
            </a>
        @endforeach
    </div>
</div>
