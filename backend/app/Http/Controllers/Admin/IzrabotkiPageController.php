<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IzrabotkiPageController extends Controller
{
    private const SETTING_KEY = 'izrabotki_page';

    private const SECTION_COUNT = 4;

    private const MOBILE_CARD_COUNT = 3;

    /** Број на тесни слики во хармониката (лентата) по секција */
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
            'intro_title' => ['nullable', 'string', 'max:500'],
            'intro_body' => ['required', 'string'],
            'quote' => ['nullable', 'string', 'max:2000'],
            'scroll_quotes_text' => ['nullable', 'string'],
            'sections' => ['required', 'array', 'size:'.self::SECTION_COUNT],
            'sections.*.layout' => ['required', 'in:images_left,images_right'],
            'sections.*.title' => ['nullable', 'string', 'max:500'],
            'sections.*.body' => ['required', 'string'],
            'mobile_cards' => ['required', 'array', 'size:'.self::MOBILE_CARD_COUNT],
            'mobile_cards.*.title' => ['nullable', 'string', 'max:500'],
            'mobile_cards.*.body' => ['nullable', 'string'],
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

        $scrollQuotes = $this->linesToArray($validated['scroll_quotes_text'] ?? '');
        if (count($scrollQuotes) < 1) {
            $scrollQuotes = $existing['scroll_quotes'] ?? $this->defaultData()['scroll_quotes'];
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

            $sections[] = [
                'layout' => $row['layout'],
                'title' => $row['title'] ?? '',
                'body' => $row['body'],
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

            $mobile[] = [
                'image' => $imgPath,
                'title' => trim((string) ($row['title'] ?? '')),
                'body' => trim((string) ($row['body'] ?? '')),
            ];
        }

        SystemSetting::updateOrCreate(
            ['setting_key' => self::SETTING_KEY],
            [
                'value' => json_encode([
                    'hero_bg' => $heroBg,
                    'intro_title' => $validated['intro_title'] ?? '',
                    'intro_body' => $validated['intro_body'],
                    'quote' => $validated['quote'] ?? '',
                    'scroll_quotes' => array_values($scrollQuotes),
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
        return $this->getData();
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

        return array_replace_recursive($default, is_array($decoded) ? $decoded : []);
    }

    private function linesToArray(?string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $text);
        $out = [];

        if (! is_array($lines)) {
            return $out;
        }

        foreach ($lines as $line) {
            $t = trim((string) $line);

            if ($t !== '') {
                $out[] = $t;
            }
        }

        return $out;
    }

    private function defaultData(): array
    {
        $q = '„Во секој бод и секој засек има дел од мојата тишина. Работилницата ми е како терапија – таму не сум само затвореник, туку човек што учи, создава и се надева.“';

        $defaultStrips = [
            'https://picsum.photos/500/400?1',
            'https://picsum.photos/500/400?2',
            'https://picsum.photos/500/400?3',
            'https://picsum.photos/500/400?4',
        ];

        return [
            'hero_bg' => 'images/ChatGPT Image Apr 28, 2026, 10_45_13 PM.png',
            'intro_title' => '',
            'intro_body' => 'Во рамките на КПД Идризово, осудениците активно учествуваат во работилници каде што изработуваат различни рачни предмети како: капи, шалови, слики, декорации, дрворези итн. Овие активности придонесуваат кон развој на нови вештини, креативност и подготовка за независен живот по издржувањето на казната. Работилниците се дел од програмите за ресоцијализација и поддршка во процесот на рехабилитација.',
            'quote' => '„Секој производ носи своја приказна и допринесува за ресоцијализација.“',
            'scroll_quotes' => array_fill(0, 8, $q),
            'sections' => [
                [
                    'layout' => 'images_left',
                    'title' => 'Уметност со игла и конец',
                    'body' => 'Во затворската работилница, конецот и иглата стануваат повеќе од алатки – тие се мост кон внатрешна слобода. Затворениците со трпеливи движења плетат ташни и кошули, секој бод е чекор кон дисциплина и самоконтрола. Процесот бара смиреност и концентрација, насочувајќи ја мислата кон нешто позитивно.',
                    'main_image' => 'https://picsum.photos/500/400',
                    'strip_images' => $defaultStrips,
                ],
                [
                    'layout' => 'images_right',
                    'title' => 'Резби од дрво',
                    'body' => 'Во затворската работилница, дрвото станува средство за тишина, фокус и внатрешна трансформација. Затвореникот, со ограничена слобода но со неисцрпна потреба за изразување, го зема парче дрво и преку трпеливо резбање создава сцени од библиски митови, природата или сопствените сеќавања.',
                    'main_image' => 'https://picsum.photos/600/800?random=5',
                    'strip_images' => $defaultStrips,
                ],
                [
                    'layout' => 'images_left',
                    'title' => 'Боја и перспектива: слики од работилницата',
                    'body' => 'Во затворот, хартијата и боите стануваат прозорец кон слобода. Затворениците цртаат пејзажи, куќи, дрвја и небо — сцени што ги потсетуваат на светот надвор, но и на светот во нив.',
                    'main_image' => 'https://picsum.photos/500/400',
                    'strip_images' => $defaultStrips,
                ],
                [
                    'layout' => 'images_right',
                    'title' => 'Грнчарство',
                    'body' => "Во тишината на затворската работилница, каде времето тече поинаку, глината станува глас. Грнчарството овде не е само занает – тоа е процес на преобразба. Осудените лица преку грнчарството учат да создаваат, а не да уништуваат. Во секое грне, чинија или вазна, се втиснува нивната историја, нивната борба и нивната желба за нов почеток. Работата со глина бара концентрација, дисциплина и емпатија – вредности што често недостасуваат во нивните животи пред затворот. Овие грнчарски производи не се само предмети – тие се сведоштва. Преку продажба на овие рачно изработени предмети, се поддржува рехабилитацијата и се гради мост кон заедницата. Купувачите не добиваат само уникатен производ – тие стануваат дел од приказна за надеж, достоинство и втори шанси.",
                    'main_image' => 'https://picsum.photos/600/800?random=5',
                    'strip_images' => $defaultStrips,
                ],
            ],
            'mobile_cards' => [
                ['image' => 'https://picsum.photos/500/400?1', 'title' => '', 'body' => ''],
                ['image' => 'https://picsum.photos/500/400?2', 'title' => '', 'body' => ''],
                ['image' => 'https://picsum.photos/500/400?3', 'title' => '', 'body' => ''],
            ],
        ];
    }
}
