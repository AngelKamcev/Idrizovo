<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUrl;
use App\Helpers\LocalizedContent;
use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class IzrabotkiPageController extends Controller
{
    private const SETTING_KEY = 'izrabotki_page';

    private const SECTION_COUNT = 4;

    private const MOBILE_CARD_COUNT = 3;

    private const STRIP_SLOTS = 4;

    public function edit()
    {
        return view('admin.izrabotki', [
            'data' => $this->getData(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'hero_bg_existing' => ['nullable', 'string', 'max:500'],
            'hero_upload' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'intro_title_mk' => ['nullable', 'string', 'max:500'],
            'intro_title_en' => ['nullable', 'string', 'max:500'],
            'intro_title_sq' => ['nullable', 'string', 'max:500'],
            'intro_body_mk' => ['required', 'string'],
            'intro_body_en' => ['nullable', 'string'],
            'intro_body_sq' => ['nullable', 'string'],
            'quote_mk' => ['nullable', 'string', 'max:2000'],
            'quote_en' => ['nullable', 'string', 'max:2000'],
            'quote_sq' => ['nullable', 'string', 'max:2000'],
            'scroll_quotes_text_mk' => ['nullable', 'string'],
            'scroll_quotes_text_en' => ['nullable', 'string'],
            'scroll_quotes_text_sq' => ['nullable', 'string'],
            'sections' => ['required', 'array', 'size:'.self::SECTION_COUNT],
            'sections.*.layout' => ['required', 'in:images_left,images_right'],
            'sections.*.title_mk' => ['nullable', 'string', 'max:500'],
            'sections.*.title_en' => ['nullable', 'string', 'max:500'],
            'sections.*.title_sq' => ['nullable', 'string', 'max:500'],
            'sections.*.body_mk' => ['required', 'string'],
            'sections.*.body_en' => ['nullable', 'string'],
            'sections.*.body_sq' => ['nullable', 'string'],
            'mobile_cards' => ['required', 'array', 'size:'.self::MOBILE_CARD_COUNT],
            'mobile_cards.*.title_mk' => ['nullable', 'string', 'max:500'],
            'mobile_cards.*.title_en' => ['nullable', 'string', 'max:500'],
            'mobile_cards.*.title_sq' => ['nullable', 'string', 'max:500'],
            'mobile_cards.*.body_mk' => ['nullable', 'string'],
            'mobile_cards.*.body_en' => ['nullable', 'string'],
            'mobile_cards.*.body_sq' => ['nullable', 'string'],
        ];

        for ($i = 0; $i < self::SECTION_COUNT; $i++) {
            $rules["main_existing_$i"] = ['nullable', 'string', 'max:500'];
            $rules["main_upload_$i"] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'];

            for ($j = 0; $j < self::STRIP_SLOTS; $j++) {
                $rules["strip_existing_{$i}_{$j}"] = ['nullable', 'string', 'max:500'];
                $rules["strip_upload_{$i}_{$j}"] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'];
            }
        }

        for ($i = 0; $i < self::MOBILE_CARD_COUNT; $i++) {
            $rules["mobile_image_existing_$i"] = ['nullable', 'string', 'max:500'];
            $rules["mobile_image_upload_$i"] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'];
        }

        $validated = $request->validate($rules);
        $existing = $this->getData();

        $heroBg = (string) ($request->input('hero_bg_existing') ?? ($existing['hero_bg'] ?? ''));
        if ($request->hasFile('hero_upload')) {
            $this->deleteIfIzrabotkiPath($heroBg);
            $heroBg = $request->file('hero_upload')->store('izrabotki', 'public');
        }

        $existingScroll = LocalizedContent::normalizeLines($existing['scroll_quotes'] ?? []);
        $scrollQuotes = LocalizedContent::linesFromRequest(
            LocalizedContent::splitLines($validated['scroll_quotes_text_mk'] ?? ''),
            LocalizedContent::splitLines($validated['scroll_quotes_text_en'] ?? ''),
            LocalizedContent::splitLines($validated['scroll_quotes_text_sq'] ?? ''),
            $existingScroll
        );

        if ($scrollQuotes['mk'] === []) {
            $scrollQuotes = $existingScroll['mk'] !== []
                ? $existingScroll
                : LocalizedContent::normalizeLines($this->defaultData()['scroll_quotes']);
        }

        $sectionRows = $validated['sections'];
        ksort($sectionRows);
        $sectionRows = array_values($sectionRows);
        $sections = [];

        foreach ($sectionRows as $index => $row) {
            $main = (string) $request->input("main_existing_$index", ($existing['sections'][$index]['main_image'] ?? ''));

            if ($request->hasFile("main_upload_$index")) {
                $this->deleteIfIzrabotkiPath($main);
                $main = $request->file("main_upload_$index")->store('izrabotki', 'public');
            }

            $oldStrips = $existing['sections'][$index]['strip_images'] ?? [];
            if (! is_array($oldStrips)) {
                $oldStrips = [];
            }

            $defaults = $this->defaultData()['sections'][$index]['strip_images'] ?? [];
            $strips = [];

            for ($j = 0; $j < self::STRIP_SLOTS; $j++) {
                $slotPath = (string) $request->input("strip_existing_{$index}_{$j}", ($oldStrips[$j] ?? ''));

                if ($request->hasFile("strip_upload_{$index}_{$j}")) {
                    $this->deleteIfIzrabotkiPath($slotPath);
                    $slotPath = $request->file("strip_upload_{$index}_{$j}")->store('izrabotki', 'public');
                }

                if ($slotPath === '') {
                    $slotPath = (string) ($defaults[$j] ?? '');
                }

                if ($slotPath === '') {
                    $slotPath = $main !== '' ? $main : 'https://picsum.photos/500/400?'.($index * 4 + $j);
                }

                $strips[] = $slotPath;
            }

            $existingSection = $existing['sections'][$index] ?? [];

            $sections[] = [
                'layout' => $row['layout'],
                'title' => LocalizedContent::fromRequest(
                    $row['title_mk'] ?? '',
                    $row['title_en'] ?? '',
                    $row['title_sq'] ?? '',
                    LocalizedContent::normalize($existingSection['title'] ?? '')
                ),
                'body' => LocalizedContent::fromRequest(
                    $row['body_mk'] ?? '',
                    $row['body_en'] ?? '',
                    $row['body_sq'] ?? '',
                    LocalizedContent::normalize($existingSection['body'] ?? '')
                ),
                'main_image' => $main,
                'strip_images' => array_slice($strips, 0, self::STRIP_SLOTS),
            ];
        }

        $mobile = [];
        $mobileRows = $validated['mobile_cards'];
        ksort($mobileRows);
        $mobileRows = array_values($mobileRows);

        foreach ($mobileRows as $index => $row) {
            $imgPath = (string) $request->input("mobile_image_existing_$index", ($existing['mobile_cards'][$index]['image'] ?? ''));

            if ($request->hasFile("mobile_image_upload_$index")) {
                $this->deleteIfIzrabotkiPath($imgPath);
                $imgPath = $request->file("mobile_image_upload_$index")->store('izrabotki', 'public');
            }

            $existingCard = $existing['mobile_cards'][$index] ?? [];

            $mobile[] = [
                'image' => $imgPath,
                'title' => LocalizedContent::fromRequest(
                    $row['title_mk'] ?? '',
                    $row['title_en'] ?? '',
                    $row['title_sq'] ?? '',
                    LocalizedContent::normalize($existingCard['title'] ?? '')
                ),
                'body' => LocalizedContent::fromRequest(
                    $row['body_mk'] ?? '',
                    $row['body_en'] ?? '',
                    $row['body_sq'] ?? '',
                    LocalizedContent::normalize($existingCard['body'] ?? '')
                ),
            ];
        }

        foreach (['mk', 'en', 'sq'] as $locale) {
            Cache::forget('izrabotki_page_data_'.$locale);
        }
        SystemSetting::updateOrCreate(
            ['setting_key' => self::SETTING_KEY],
            [
                'value' => json_encode([
                    'hero_bg' => $heroBg,
                    'intro_title' => LocalizedContent::fromRequest(
                        $validated['intro_title_mk'] ?? '',
                        $validated['intro_title_en'] ?? '',
                        $validated['intro_title_sq'] ?? '',
                        LocalizedContent::normalize($existing['intro_title'] ?? '')
                    ),
                    'intro_body' => LocalizedContent::fromRequest(
                        $validated['intro_body_mk'],
                        $validated['intro_body_en'] ?? '',
                        $validated['intro_body_sq'] ?? '',
                        LocalizedContent::normalize($existing['intro_body'] ?? '')
                    ),
                    'quote' => LocalizedContent::fromRequest(
                        $validated['quote_mk'] ?? '',
                        $validated['quote_en'] ?? '',
                        $validated['quote_sq'] ?? '',
                        LocalizedContent::normalize($existing['quote'] ?? '')
                    ),
                    'scroll_quotes' => $scrollQuotes,
                    'sections' => $sections,
                    'mobile_cards' => $mobile,
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'updated_by' => $request->user()?->id,
            ]
        );

        return redirect()
            ->route('admin.izrabotki')
            ->with('success', 'Податоците за „Изработки“ се зачувани.');
    }

    public function publicData(): array
    {
        return $this->localizeForLocale($this->getData(), app()->getLocale());
    }

    private function deleteIfIzrabotkiPath(?string $relativePath): void
    {
        $relativePath = (string) $relativePath;

        if ($relativePath === '' || str_contains($relativePath, '..')) {
            return;
        }

        if (! str_starts_with($relativePath, 'izrabotki/')) {
            return;
        }

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function getData(): array
    {
        $default = $this->defaultData();
        $setting = SystemSetting::where('setting_key', self::SETTING_KEY)->first();

        if (! $setting || ! $setting->value) {
            return $default;
        }

        $decoded = json_decode($setting->value, true);
        $data = array_replace_recursive($default, is_array($decoded) ? $decoded : []);

        return $this->sanitizeMissingImages($this->normalizeStoredData($data), $default);
    }

    private function normalizeStoredData(array $data): array
    {
        $data['intro_title'] = LocalizedContent::normalize($data['intro_title'] ?? '');
        $data['intro_body'] = LocalizedContent::normalize($data['intro_body'] ?? '');
        $data['quote'] = LocalizedContent::normalize($data['quote'] ?? '');
        $data['scroll_quotes'] = LocalizedContent::normalizeLines($data['scroll_quotes'] ?? []);

        foreach (($data['sections'] ?? []) as $index => $section) {
            $data['sections'][$index]['title'] = LocalizedContent::normalize($section['title'] ?? '');
            $data['sections'][$index]['body'] = LocalizedContent::normalize($section['body'] ?? '');
        }

        foreach (($data['mobile_cards'] ?? []) as $index => $card) {
            $data['mobile_cards'][$index]['title'] = LocalizedContent::normalize($card['title'] ?? '');
            $data['mobile_cards'][$index]['body'] = LocalizedContent::normalize($card['body'] ?? '');
        }

        return $data;
    }

    private function localizeForLocale(array $data, string $locale): array
    {
        $data['intro_title'] = LocalizedContent::pick($data['intro_title'] ?? '', $locale);
        $data['intro_body'] = LocalizedContent::pick($data['intro_body'] ?? '', $locale);
        $data['quote'] = LocalizedContent::pick($data['quote'] ?? '', $locale);
        $data['scroll_quotes'] = LocalizedContent::pickLines($data['scroll_quotes'] ?? [], $locale);

        foreach (($data['sections'] ?? []) as $index => $section) {
            $data['sections'][$index]['title'] = LocalizedContent::pick($section['title'] ?? '', $locale);
            $data['sections'][$index]['body'] = LocalizedContent::pick($section['body'] ?? '', $locale);
        }

        foreach (($data['mobile_cards'] ?? []) as $index => $card) {
            $data['mobile_cards'][$index]['title'] = LocalizedContent::pick($card['title'] ?? '', $locale);
            $data['mobile_cards'][$index]['body'] = LocalizedContent::pick($card['body'] ?? '', $locale);
        }

        return $data;
    }

    private function sanitizeMissingImages(array $data, array $default): array
    {
        $data['hero_bg'] = ImageUrl::resolveOrFallback(
            $data['hero_bg'] ?? '',
            $default['hero_bg'] ?? 'https://picsum.photos/1600/900'
        );

        foreach (($data['sections'] ?? []) as $index => $section) {
            $defaultSection = $default['sections'][$index] ?? [];
            $data['sections'][$index]['main_image'] = ImageUrl::resolveOrFallback(
                $section['main_image'] ?? '',
                $defaultSection['main_image'] ?? 'https://picsum.photos/500/400'
            );

            $strips = [];

            foreach (($section['strip_images'] ?? []) as $stripIndex => $strip) {
                $defaultStrip = $defaultSection['strip_images'][$stripIndex] ?? 'https://picsum.photos/500/400?'.($stripIndex + 1);
                $strips[] = ImageUrl::resolveOrFallback($strip, $defaultStrip) ?: $defaultStrip;
            }

            $data['sections'][$index]['strip_images'] = $strips;
        }

        foreach (($data['mobile_cards'] ?? []) as $index => $card) {
            $defaultCard = $default['mobile_cards'][$index] ?? [];
            $data['mobile_cards'][$index]['image'] = ImageUrl::resolveOrFallback(
                $card['image'] ?? '',
                $defaultCard['image'] ?? 'https://picsum.photos/500/400?'.($index + 1)
            );
        }

        return $data;
    }

    private function defaultData(): array
    {
        $qMk = '„Во секој бод и секој засек има дел од мојата тишина. Работилницата ми е како терапија – таму не сум само затвореник, туку човек што учи, создава и се надева.“';
        $qEn = '"In every stitch and every cut there is a part of my silence. The workshop is like therapy for me – there I am not only a prisoner, but a person who learns, creates and hopes."';
        $qSq = '"Në çdo qepje dhe çdo prerje ka një pjesë të heshtjes sime. Punëtoria është si terapi për mua – atje nuk jam vetëm i burgosur, por njeri që mëson, krijon dhe shpreson."';

        $defaultStrips = [
            'https://picsum.photos/500/400?1',
            'https://picsum.photos/500/400?2',
            'https://picsum.photos/500/400?3',
            'https://picsum.photos/500/400?4',
        ];

        return [
            'hero_bg' => 'https://picsum.photos/1600/900',
            'intro_title' => ['mk' => '', 'en' => '', 'sq' => ''],
            'intro_body' => [
                'mk' => 'Во рамките на КПД Идризово, осудениците активно учествуваат во работилници каде што изработуваат различни рачни предмети како: капи, шалови, слики, декорации, дрворези итн. Овие активности придонесуваат кон развој на нови вештини, креативност и подготовка за независен живот по издржувањето на казната. Работилниците се дел од програмите за ресоцијализација и поддршка во процесот на рехабилитација.',
                'en' => 'Within KPD Idrizovo, inmates actively participate in workshops where they make various handmade items such as caps, scarves, paintings, decorations, wood carvings and more. These activities contribute to developing new skills, creativity and preparation for independent life after serving a sentence. The workshops are part of resocialization and rehabilitation support programs.',
                'sq' => 'Brenda KPD Idrizovo, të burgosurit marrin pjesë aktivisht në punëtori ku prodhojnë artikuj të ndryshëm të punuar me dorë si kapele, shallë, piktura, dekoracione, gdhendje druri etj. Këto aktivitete kontribuojnë në zhvillimin e aftësive të reja, kreativitetit dhe përgatitjen për jetë të pavarur pas kryerjes së dënimit.',
            ],
            'quote' => [
                'mk' => '„Секој производ носи своја приказна и допринесува за ресоцијализација.“',
                'en' => '"Every product carries its own story and contributes to resocialization."',
                'sq' => '"Çdo produkt mbart historinë e vet dhe kontribuon në resocializim."',
            ],
            'scroll_quotes' => [
                'mk' => array_fill(0, 8, $qMk),
                'en' => array_fill(0, 8, $qEn),
                'sq' => array_fill(0, 8, $qSq),
            ],
            'sections' => [
                [
                    'layout' => 'images_left',
                    'title' => [
                        'mk' => 'Уметност со игла и конец',
                        'en' => 'Art with needle and thread',
                        'sq' => 'Art me grep dhe fije',
                    ],
                    'body' => [
                        'mk' => 'Во затворската работилница, конецот и иглата стануваат повеќе од алатки – тие се мост кон внатрешна слобода. Затворениците со трпеливи движења плетат ташни и кошули, секој бод е чекор кон дисциплина и самоконтрола. Процесот бара смиреност и концентрација, насочувајќи ја мислата кон нешто позитивно.',
                        'en' => 'In the prison workshop, thread and needle become more than tools – they are a bridge to inner freedom. Inmates patiently knit bags and shirts; every stitch is a step toward discipline and self-control. The process demands calm and focus, directing the mind toward something positive.',
                        'sq' => 'Në punëtoriën e burgut, fija dhe grepi bëhen më shumë se mjete – janë urë drejt lirisë së brendshme. Të burgosurit thurin me durim çanta dhe këmisha; çdo qepje është hap drejt disiplinës dhe vetëkontrollit.',
                    ],
                    'main_image' => 'https://picsum.photos/500/400',
                    'strip_images' => $defaultStrips,
                ],
                [
                    'layout' => 'images_right',
                    'title' => [
                        'mk' => 'Резби од дрво',
                        'en' => 'Wood carvings',
                        'sq' => 'Gdhendje druri',
                    ],
                    'body' => [
                        'mk' => 'Во затворската работилница, дрвото станува средство за тишина, фокус и внатрешна трансформација. Затвореникот, со ограничена слобода но со неисцрпна потреба за изразување, го зема парче дрво и преку трпеливо резбање создава сцени од библиски митови, природата или сопствените сеќавања.',
                        'en' => 'In the prison workshop, wood becomes a means of silence, focus and inner transformation. With limited freedom but an endless need to express, the inmate takes a piece of wood and through patient carving creates scenes from biblical myths, nature or personal memories.',
                        'sq' => 'Në punëtoriën e burgut, druri bëhet mjet për heshtje, fokus dhe transformim të brendshëm. Me liri të kufizuar por nevojë të pafundme për shprehje, i burgosuri merr një copë druri dhe përmes gdhendjes me durim krijon skena nga mite biblike, natyra ose kujtime personale.',
                    ],
                    'main_image' => 'https://picsum.photos/600/800?random=5',
                    'strip_images' => $defaultStrips,
                ],
                [
                    'layout' => 'images_left',
                    'title' => [
                        'mk' => 'Боја и перспектива: слики од работилницата',
                        'en' => 'Color and perspective: paintings from the workshop',
                        'sq' => 'Ngjyra dhe perspektivë: piktura nga punëtoria',
                    ],
                    'body' => [
                        'mk' => 'Во затворот, хартијата и боите стануваат прозорец кон слобода. Затворениците цртаат пејзажи, куќи, дрвја и небо — сцени што ги потсетуваат на светот надвор, но и на светот во нив.',
                        'en' => 'In prison, paper and paint become a window to freedom. Inmates draw landscapes, houses, trees and sky — scenes that remind them of the world outside, but also the world within.',
                        'sq' => 'Në burg, letra dhe bojat bëhen dritare drejt lirisë. Të burgosurit vizatojnë peizazhe, shtëpi, pemë dhe qiell — skena që u kujtojnë botën jashtë, por edhe botën brenda tyre.',
                    ],
                    'main_image' => 'https://picsum.photos/500/400',
                    'strip_images' => $defaultStrips,
                ],
                [
                    'layout' => 'images_right',
                    'title' => [
                        'mk' => 'Грнчарство',
                        'en' => 'Pottery',
                        'sq' => 'Poterie',
                    ],
                    'body' => [
                        'mk' => 'Во тишината на затворската работилница, каде времето тече поинаку, глината станува глас. Грнчарството овде не е само занает – тоа е процес на преобразба.',
                        'en' => 'In the silence of the prison workshop, where time flows differently, clay becomes a voice. Pottery here is not only a craft – it is a process of transformation.',
                        'sq' => 'Në heshtjen e punëtorisë së burgut, ku koha rrjedh ndryshe, argjila bëhet zë. Poterie këtu nuk është vetëm zanat – është proces transformimi.',
                    ],
                    'main_image' => 'https://picsum.photos/600/800?random=5',
                    'strip_images' => $defaultStrips,
                ],
            ],
            'mobile_cards' => [
                ['image' => 'https://picsum.photos/500/400?1', 'title' => ['mk' => '', 'en' => '', 'sq' => ''], 'body' => ['mk' => '', 'en' => '', 'sq' => '']],
                ['image' => 'https://picsum.photos/500/400?2', 'title' => ['mk' => '', 'en' => '', 'sq' => ''], 'body' => ['mk' => '', 'en' => '', 'sq' => '']],
                ['image' => 'https://picsum.photos/500/400?3', 'title' => ['mk' => '', 'en' => '', 'sq' => ''], 'body' => ['mk' => '', 'en' => '', 'sq' => '']],
            ],
        ];
    }
}
