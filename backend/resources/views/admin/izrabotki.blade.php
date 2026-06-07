@extends('admin.layouts.app')

@section('title', 'Рачни Изработки')
@section('page-title', 'Рачни Изработки')
@section('page-subtitle', 'Картички и слики од компјутер')

@section('content')

@php
    use App\Helpers\LocalizedContent;

    $imgUrl = function (?string $p): string {
        $p = (string) $p;
        if ($p === '') return '';
        if (preg_match('#^https?://#i', $p)) return $p;
        if (str_starts_with($p, 'izrabotki/')) return asset('storage/'.$p);
        return asset(ltrim($p, '/'));
    };
    $sections = $data['sections'] ?? [];
    while (count($sections) < 4) {
        $sections[] = ['layout' => 'images_left', 'title' => '', 'body' => '', 'main_image' => '', 'strip_images' => []];
    }
    $sections = array_slice($sections, 0, 4);
    $mobileCards = $data['mobile_cards'] ?? [];
    while (count($mobileCards) < 3) {
        $mobileCards[] = ['image' => '', 'title' => '', 'body' => ''];
    }
    $mobileCards = array_slice($mobileCards, 0, 3);
    $introTitle = LocalizedContent::normalize($data['intro_title'] ?? '');
    $introBody = LocalizedContent::normalize($data['intro_body'] ?? '');
    $quote = LocalizedContent::normalize($data['quote'] ?? '');
    $scrollQuotes = LocalizedContent::normalizeLines($data['scroll_quotes'] ?? []);
@endphp

@if (session('success'))
<div class="mb-6 flex items-center gap-3 rounded-lg border border-[#c9a84c]/30 bg-[#faf6ed] px-4 py-3 text-sm text-[#7a5c10]">
    <svg class="w-4 h-4 text-[#c9a84c] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
    <ul class="list-inside list-disc space-y-1">
        @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.izrabotki.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
@csrf

{{-- Hero --}}
<div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#ddd9d0] flex items-center gap-3">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Позадина · Hero</h3>
    </div>
    <div class="p-6">
        <input type="hidden" name="hero_bg_existing" value="{{ old('hero_bg_existing', $data['hero_bg'] ?? '') }}">
        @if (!empty($data['hero_bg']))
        <div class="mb-5">
            <p class="text-xs font-medium text-[#888] uppercase tracking-widest mb-2">Тековна слика</p>
            <div class="h-44 w-full max-w-lg overflow-hidden rounded-lg border border-[#ddd9d0] bg-cover bg-center"
                 style="background-image: url('{{ $imgUrl($data['hero_bg']) }}')"></div>
        </div>
        @endif
        <label class="block text-xs font-medium text-[#555] mb-2">Нова слика (остави празно за да остане постоечката)</label>
        <input type="file" name="hero_upload" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
               class="block w-full max-w-md text-xs text-[#666] file:mr-3 file:rounded file:border-0 file:bg-[#0E1B2F] file:px-4 file:py-2 file:text-xs file:font-medium file:text-white hover:file:bg-[#1e3251]">
        <p class="mt-2 text-xs text-[#aaa]">Препорака: широка слика.</p>
    </div>
</div>

{{-- Текст --}}
<div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#ddd9d0] flex items-center gap-3">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Текст на страната</h3>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Наслов на вовед (Македонски) <span class="text-[#aaa] font-normal">(празно = превод на страната)</span></label>
            <input type="text" name="intro_title_mk" value="{{ old('intro_title_mk', $introTitle['mk']) }}"
                   class="w-full max-w-2xl rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">
        </div>
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Вовед (Македонски) <span class="text-red-500">*</span></label>
            <textarea name="intro_body_mk" rows="4"
                      class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30" required>{{ old('intro_body_mk', $introBody['mk']) }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Цитат (Македонски)</label>
            <textarea name="quote_mk" rows="2"
                      class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">{{ old('quote_mk', $quote['mk']) }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Лента со цитати (Македонски)</label>
            <textarea name="scroll_quotes_text_mk" rows="6"
                      class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 font-mono text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">{{ old('scroll_quotes_text_mk', LocalizedContent::linesToText($scrollQuotes['mk'])) }}</textarea>
        </div>

        @include('admin.partials.ai-translate', [
            'buttonId' => 'izIntroTranslate',
            'fieldMap' => [
                'title' => ['mk' => 'intro_title_mk', 'en' => 'intro_title_en', 'sq' => 'intro_title_sq'],
                'body' => ['mk' => 'intro_body_mk', 'en' => 'intro_body_en', 'sq' => 'intro_body_sq'],
                'quote' => ['mk' => 'quote_mk', 'en' => 'quote_en', 'sq' => 'quote_sq'],
            ],
        ])

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Наслов на вовед (Англиски)</label>
                <input type="text" name="intro_title_en" value="{{ old('intro_title_en', $introTitle['en']) }}"
                       class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 text-sm text-[#0E1B2F]">
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Наслов на вовед (Албански)</label>
                <input type="text" name="intro_title_sq" value="{{ old('intro_title_sq', $introTitle['sq']) }}"
                       class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 text-sm text-[#0E1B2F]">
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Вовед (Англиски)</label>
                <textarea name="intro_body_en" rows="4"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 text-sm text-[#0E1B2F]">{{ old('intro_body_en', $introBody['en']) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Вовед (Албански)</label>
                <textarea name="intro_body_sq" rows="4"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 text-sm text-[#0E1B2F]">{{ old('intro_body_sq', $introBody['sq']) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Цитат (Англиски)</label>
                <textarea name="quote_en" rows="2"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 text-sm text-[#0E1B2F]">{{ old('quote_en', $quote['en']) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Цитат (Албански)</label>
                <textarea name="quote_sq" rows="2"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 text-sm text-[#0E1B2F]">{{ old('quote_sq', $quote['sq']) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Лента со цитати (Англиски)</label>
                <textarea name="scroll_quotes_text_en" rows="6"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 font-mono text-sm text-[#0E1B2F]">{{ old('scroll_quotes_text_en', LocalizedContent::linesToText($scrollQuotes['en'])) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#555] mb-1.5">Лента со цитати (Албански)</label>
                <textarea name="scroll_quotes_text_sq" rows="6"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2.5 font-mono text-sm text-[#0E1B2F]">{{ old('scroll_quotes_text_sq', LocalizedContent::linesToText($scrollQuotes['sq'])) }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- Десктоп работилници --}}
<div>
    <div class="flex items-center gap-3 mb-5">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Работилници · Десктоп</h3>
        <span class="text-xs text-[#aaa]">4 картички</span>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        @foreach ($sections as $i => $sec)
        @php
            $secTitle = LocalizedContent::normalize($sec['title'] ?? '');
            $secBody = LocalizedContent::normalize($sec['body'] ?? '');
        @endphp
        <div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">

            <div class="px-5 py-3 bg-[#0E1B2F] flex items-center justify-between">
                <span class="text-xs font-semibold text-white tracking-widest uppercase">Картичка {{ $i + 1 }}</span>
                <select name="sections[{{ $i }}][layout]"
                        class="rounded border border-white/20 bg-white/10 px-2 py-1 text-xs text-white focus:outline-none">
                    <option value="images_left" @selected(old("sections.$i.layout", $sec['layout'] ?? '') === 'images_left')>Слики лево</option>
                    <option value="images_right" @selected(old("sections.$i.layout", $sec['layout'] ?? '') === 'images_right')>Слики десно</option>
                </select>
            </div>

            <div class="p-5 space-y-5">

                {{-- Main image --}}
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-[#888] mb-2">Главна слика</p>
                    <input type="hidden" name="main_existing_{{ $i }}" value="{{ old("main_existing_$i", $sec['main_image'] ?? '') }}">
                    @if (!empty($sec['main_image']))
                        <img src="{{ $imgUrl($sec['main_image']) }}" alt=""
                             class="mb-2 h-28 w-full rounded-lg border border-[#ddd9d0] object-cover">
                    @else
                        <div class="mb-2 flex h-28 items-center justify-center rounded-lg border border-dashed border-[#d4cfc4] bg-white text-xs text-[#aaa]">
                            Нема слика
                        </div>
                    @endif
                    <input type="file" name="main_upload_{{ $i }}" accept="image/*"
                           class="block w-full text-xs text-[#666] file:mr-2 file:rounded file:border-0 file:bg-[#0E1B2F] file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-[#1e3251]">
                </div>

                {{-- Strip images --}}
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-[#888] mb-2">Хармоника — 4 слики</p>
                    <div class="grid grid-cols-2 gap-2">
                        @for ($j = 0; $j < 4; $j++)
                            @php $stripPath = $sec['strip_images'][$j] ?? ''; @endphp
                            <div class="rounded-lg border border-[#ddd9d0] bg-white p-2.5">
                                <p class="mb-1.5 text-[9px] font-bold uppercase tracking-widest text-[#c9a84c]">{{ $j + 1 }}</p>
                                <input type="hidden" name="strip_existing_{{ $i }}_{{ $j }}"
                                       value="{{ old("strip_existing_{$i}_{$j}", $stripPath) }}">
                                @if ($stripPath !== '')
                                    <img src="{{ $imgUrl($stripPath) }}" alt=""
                                         class="mb-1.5 h-16 w-full rounded object-cover border border-[#ddd9d0]">
                                @else
                                    <div class="mb-1.5 flex h-16 items-center justify-center rounded border border-dashed border-[#d4cfc4] bg-[#f5f3ef] text-[9px] text-[#bbb]">—</div>
                                @endif
                                <input type="file" name="strip_upload_{{ $i }}_{{ $j }}" accept="image/*"
                                       class="block w-full text-[10px] text-[#666] file:mr-1 file:rounded file:border-0 file:bg-[#f5f3ef] file:px-1.5 file:py-0.5 file:text-[10px]">
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Text --}}
                <div class="space-y-2.5">
                    <input type="text" name="sections[{{ $i }}][title_mk]"
                           value="{{ old("sections.$i.title_mk", $secTitle['mk']) }}"
                           placeholder="Наслов (МК)"
                           class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">
                    <textarea name="sections[{{ $i }}][body_mk]" rows="4"
                              placeholder="Текст (МК)"
                              class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30" required>{{ old("sections.$i.body_mk", $secBody['mk']) }}</textarea>

                    @include('admin.partials.ai-translate', [
                        'buttonId' => 'izSectionTranslate'.$i,
                        'fieldMap' => [
                            'title' => ['mk' => "sections[{$i}][title_mk]", 'en' => "sections[{$i}][title_en]", 'sq' => "sections[{$i}][title_sq]"],
                            'body' => ['mk' => "sections[{$i}][body_mk]", 'en' => "sections[{$i}][body_en]", 'sq' => "sections[{$i}][body_sq]"],
                        ],
                    ])

                    <div class="grid gap-2 md:grid-cols-2">
                        <input type="text" name="sections[{{ $i }}][title_en]"
                               value="{{ old("sections.$i.title_en", $secTitle['en']) }}"
                               placeholder="Наслов (EN)"
                               class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">
                        <input type="text" name="sections[{{ $i }}][title_sq]"
                               value="{{ old("sections.$i.title_sq", $secTitle['sq']) }}"
                               placeholder="Наслов (SQ)"
                               class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">
                        <textarea name="sections[{{ $i }}][body_en]" rows="3"
                                  placeholder="Текст (EN)"
                                  class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">{{ old("sections.$i.body_en", $secBody['en']) }}</textarea>
                        <textarea name="sections[{{ $i }}][body_sq]" rows="3"
                                  placeholder="Текст (SQ)"
                                  class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">{{ old("sections.$i.body_sq", $secBody['sq']) }}</textarea>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Мобилни картички --}}
<div>
    <div class="flex items-center gap-3 mb-5">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Мобилни картички</h3>
        <span class="text-xs text-[#aaa]">3 картички</span>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        @foreach ($mobileCards as $i => $card)
        @php
            $cardTitle = LocalizedContent::normalize($card['title'] ?? '');
            $cardBody = LocalizedContent::normalize($card['body'] ?? '');
        @endphp
        <div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">

            <div class="px-5 py-3 bg-[#0E1B2F]">
                <span class="text-xs font-semibold text-white tracking-widest uppercase">Картичка {{ $i + 1 }}</span>
            </div>

            <div class="p-5 space-y-3">
                <input type="hidden" name="mobile_image_existing_{{ $i }}"
                       value="{{ old("mobile_image_existing_$i", $card['image'] ?? '') }}">
                @if (!empty($card['image']))
                    <img src="{{ $imgUrl($card['image']) }}" alt=""
                         class="h-36 w-full rounded-lg border border-[#ddd9d0] object-cover">
                @else
                    <div class="flex h-36 items-center justify-center rounded-lg border border-dashed border-[#d4cfc4] bg-white text-xs text-[#aaa]">
                        Нема слика
                    </div>
                @endif
                <input type="file" name="mobile_image_upload_{{ $i }}" accept="image/*"
                       class="block w-full text-xs text-[#666] file:mr-2 file:rounded file:border-0 file:bg-[#0E1B2F] file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-[#1e3251]">
                <input type="text" name="mobile_cards[{{ $i }}][title_mk]"
                       value="{{ old("mobile_cards.$i.title_mk", $cardTitle['mk']) }}"
                       placeholder="Наслов (МК)"
                       class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">
                <textarea name="mobile_cards[{{ $i }}][body_mk]" rows="3"
                          placeholder="Текст (МК)"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">{{ old("mobile_cards.$i.body_mk", $cardBody['mk']) }}</textarea>

                @include('admin.partials.ai-translate', [
                    'buttonId' => 'izMobileTranslate'.$i,
                    'fieldMap' => [
                        'title' => ['mk' => "mobile_cards[{$i}][title_mk]", 'en' => "mobile_cards[{$i}][title_en]", 'sq' => "mobile_cards[{$i}][title_sq]"],
                        'body' => ['mk' => "mobile_cards[{$i}][body_mk]", 'en' => "mobile_cards[{$i}][body_en]", 'sq' => "mobile_cards[{$i}][body_sq]"],
                    ],
                ])

                <input type="text" name="mobile_cards[{{ $i }}][title_en]"
                       value="{{ old("mobile_cards.$i.title_en", $cardTitle['en']) }}"
                       placeholder="Наслов (EN)"
                       class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">
                <input type="text" name="mobile_cards[{{ $i }}][title_sq]"
                       value="{{ old("mobile_cards.$i.title_sq", $cardTitle['sq']) }}"
                       placeholder="Наслов (SQ)"
                       class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">
                <textarea name="mobile_cards[{{ $i }}][body_en]" rows="2"
                          placeholder="Текст (EN)"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">{{ old("mobile_cards.$i.body_en", $cardBody['en']) }}</textarea>
                <textarea name="mobile_cards[{{ $i }}][body_sq]" rows="2"
                          placeholder="Текст (SQ)"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-gray-50 px-3 py-2 text-sm">{{ old("mobile_cards.$i.body_sq", $cardBody['sq']) }}</textarea>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Submit --}}
<div class="flex items-center justify-end gap-4 border-t border-[#ddd9d0] pt-6">
    <span class="text-xs text-[#aaa]">Сите промени се зачувуваат одеднаш</span>
    <button type="submit"
            class="inline-flex items-center gap-2 bg-[#0E1B2F] text-white text-xs font-medium tracking-widest uppercase px-8 py-3 rounded-lg hover:bg-[#1e3251] transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        Зачувај
    </button>
</div>

</form>

@endsection