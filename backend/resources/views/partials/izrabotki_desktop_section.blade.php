@php
    $resolveUrl = function (?string $u): string {
        $u = (string) $u;
        if ($u === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $u)) {
            return $u;
        }
        if (str_starts_with($u, '/storage/') || str_starts_with($u, 'storage/')) {
            return asset(ltrim($u, '/'));
        }
        if (preg_match('#^(images|documents)/#', $u)) {
            return asset($u);
        }

        return asset('storage/'.ltrim($u, '/'));
    };
    $strips = $section['strip_images'] ?? [];
    $strips = array_values(array_filter($strips, fn ($s) => is_string($s) && $s !== ''));
@endphp

@if (($section['layout'] ?? '') === 'images_left')
<section class="py-16 hidden md:block">
    <div class="py-16">
        <div class="max-w-7xl mx-auto flex items-center gap-12 px-6">
            <div class="flex items-center">
                <div class="relative z-10">
                    <img src="{{ $resolveUrl($section['main_image'] ?? '') }}" alt="" class="w-[420px] h-[420px] object-cover rounded-2xl shadow-lg" />
                </div>
                <div class="flex -ml-16">
                    @foreach (array_slice($strips, 0, 4) as $strip)
                        <div class="group relative {{ !$loop->first ? '-ml-10' : '' }}">
                            <img src="{{ $resolveUrl($strip) }}" alt="" class="w-[70px] h-[420px] object-cover rounded-xl shadow-md transition-all duration-500 group-hover:w-[420px] group-hover:ml-4 group-hover:z-50" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="max-w-lg">
                <h2 class="text-2xl font-bold mb-4">{{ $section['title'] ?? '' }}</h2>
                <p class="text-gray-700 leading-relaxed mb-6">{!! nl2br(e($section['body'] ?? '')) !!}</p>
                <a href="{{ route('izrabotki.section', $sectionIndex) }}" class="inline-block bg-[#0E1B2F] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">{{ __('view_more') }}</a>
            </div>
        </div>
    </div>
</section>
@else
<section class="py-16 hidden md:block">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-2xl font-bold mb-4">{{ $section['title'] ?? '' }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6">{!! nl2br(e($section['body'] ?? '')) !!}</p>
            <a href="{{ route('izrabotki.section', $sectionIndex) }}" class="inline-block bg-[#0E1B2F] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">{{ __('view_more') }}</a>
        </div>
        <div class="relative flex items-center justify-end">
            @foreach (array_slice($strips, 0, 4) as $strip)
                <div class="group relative {{ !$loop->first ? '-ml-10' : '' }}">
                    <img src="{{ $resolveUrl($strip) }}" alt="" class="w-[70px] h-[420px] object-cover rounded-xl shadow-md transition-all duration-500 group-hover:w-[420px] group-hover:ml-4 group-hover:z-50" />
                </div>
            @endforeach
            <div class="overflow-hidden rounded-2xl shadow-xl w-[320px] h-[420px]">
                <img src="{{ $resolveUrl($section['main_image'] ?? '') }}" alt="" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" />
            </div>
        </div>
    </div>
</section>
@endif
