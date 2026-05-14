<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AboutUsController extends Controller
{
    private const SETTING_KEY = 'about_page';

    public function index(Request $request)
    {
        $aboutData = $this->getAboutData();

        return view('admin.aboutus', [
            'aboutData' => $aboutData,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'history_p1' => ['required', 'string'],
            'history_p2' => ['required', 'string'],
            'director_name' => ['required', 'string', 'max:255'],
            'director_title' => ['required', 'string', 'max:255'],
            'director_image_current' => ['nullable', 'string', 'max:255'],
            'director_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'deputy_name' => ['required', 'string', 'max:255'],
            'deputy_title' => ['required', 'string', 'max:255'],
            'deputy_image_current' => ['nullable', 'string', 'max:255'],
            'deputy_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'hero_image_current' => ['nullable', 'string', 'max:255'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'history_side_image_current' => ['nullable', 'string', 'max:255'],
            'history_side_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'sectors' => ['nullable', 'array'],
            'sectors.*.name' => ['nullable', 'string', 'max:500'],
            'sectors.*.img_current' => ['nullable', 'string', 'max:255'],
            'sectors.*.img_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'sectors.*.subs_text' => ['nullable', 'string'],
            'officers' => ['nullable', 'array'],
            'officers.*.name' => ['nullable', 'string', 'max:255'],
            'officers.*.role' => ['nullable', 'string', 'max:255'],
            'officers.*.email' => ['nullable', 'email', 'max:255'],
            'mission' => ['required', 'string'],
            'vision' => ['required', 'string'],
            'regulation_subtitle' => ['required', 'string', 'max:255'],
            'regulation_text' => ['required', 'string'],
            'regulation_pdf' => ['required', 'string', 'max:255'],
            'foundation_year' => ['required', 'string', 'max:20'],
            'capacity' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $officers = $this->normalizeOfficers($validated['officers'] ?? []);

        if (count($officers) < 1) {
            throw ValidationException::withMessages([
                'officers' => 'Додади барем едно одговорно лице со име.',
            ]);
        }

        $sectors = $this->normalizeSectors($validated['sectors'] ?? [], $request, $this->defaultAboutData()['sectors'] ?? []);

        if (count($sectors) < 1) {
            throw ValidationException::withMessages([
                'sectors' => 'Додади барем еден сектор со име.',
            ]);
        }

        $default = $this->defaultAboutData();
        $heroImage = $this->resolveStoredImage(
            $request->file('hero_image_file'),
            (string) ($validated['hero_image_current'] ?? ''),
            'aboutus',
            $default['hero_image']
        );
        $historySideImage = $this->resolveStoredImage(
            $request->file('history_side_image_file'),
            (string) ($validated['history_side_image_current'] ?? ''),
            'aboutus',
            $default['history_side_image']
        );
        $directorImage = $this->resolveStoredImage(
            $request->file('director_image_file'),
            (string) ($validated['director_image_current'] ?? ''),
            'aboutus',
            $default['management'][0]['image'] ?? 'images/direktor.png'
        );
        $deputyImage = $this->resolveStoredImage(
            $request->file('deputy_image_file'),
            (string) ($validated['deputy_image_current'] ?? ''),
            'aboutus',
            $default['management'][1]['image'] ?? 'images/direktor.png'
        );

        $sectors = $this->normalizeSectors($validated['sectors'] ?? [], $request, $default['sectors'] ?? []);

        SystemSetting::updateOrCreate(
            ['setting_key' => self::SETTING_KEY],
            [
                'value' => json_encode([
                    'hero_image' => $heroImage,
                    'history_side_image' => $historySideImage,
                    'history' => [
                        'p1' => $validated['history_p1'],
                        'p2' => $validated['history_p2'],
                    ],
                    'management' => [
                        [
                            'name' => $validated['director_name'],
                            'title' => $validated['director_title'],
                            'image' => $directorImage,
                        ],
                        [
                            'name' => $validated['deputy_name'],
                            'title' => $validated['deputy_title'],
                            'image' => $deputyImage,
                        ],
                    ],
                    'responsible_officers' => $officers,
                    'sectors' => $sectors,
                    'mission' => $validated['mission'],
                    'vision' => $validated['vision'],
                    'regulation' => [
                        'subtitle' => $validated['regulation_subtitle'],
                        'text' => $validated['regulation_text'],
                        'pdf' => $validated['regulation_pdf'],
                    ],
                    'quick_info' => [
                        'year' => $validated['foundation_year'],
                        'capacity' => $validated['capacity'],
                        'address' => $validated['address'],
                    ],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'updated_by' => $request->user()?->id,
            ]
        );

        return redirect()
            ->route('admin.aboutus')
            ->with('success', 'Содржината за „За Нас“ е успешно зачувана.');
    }

    private function resolveStoredImage(?\Illuminate\Http\UploadedFile $file, string $currentPath, string $folder, string $defaultPath): string
    {
        if ($file) {
            return 'storage/' . $file->store($folder, 'public');
        }

        $currentPath = trim($currentPath);

        return $currentPath !== '' ? $currentPath : $defaultPath;
    }

    private function getAboutData(): array
    {
        $default = $this->defaultAboutData();
        $setting = SystemSetting::where('setting_key', self::SETTING_KEY)->first();

        if (! $setting || ! $setting->value) {
            return $default;
        }

        $decoded = json_decode($setting->value, true);

        return array_replace_recursive($default, is_array($decoded) ? $decoded : []);
    }

    private function defaultAboutData(): array
    {
        return [
            'hero_image' => 'images/about_hero.jpeg',
            'history_side_image' => 'images/about_hero.jpeg',
            'history' => [
                'p1' => 'Казнено-поправна установа КПУ-КПД Идризово е една од главните установи за извршување на казни лишување од слобода во Република Македонија. Установата е основана со цел да обезбеди хуманен и безбеден начин на извршување на казнени санкции во согласност со национално и меѓународно право.',
                'p2' => 'Историјата на КПД Идризово започнува во текот на Втората светска војна, кога е изграден воен камп од страна на бугарската окупаторска војска. Веднаш по завршувањето на Втората светска војна продолжува да функционира како затвор – работна колонија, каде што затворениците биле ангажирани во земјоделски и градежни работи. Со текот на времето, установата се проширила и станала најголемиот затвор во државата.',
            ],
            'management' => [
                ['name' => 'М-р. Зоран Јовановски', 'title' => 'Директор', 'image' => 'direktor.png'],
                ['name' => 'Наим Љамалари', 'title' => 'Заменик директор', 'image' => 'direktor.png'],
            ],
            'responsible_officers' => [
                ['name' => 'Разије Османи Хоџа', 'role' => 'Лице за посредување со информации', 'email' => 'razije@kpuidrizovo.gov.mk'],
                ['name' => 'Горан Јовчевски', 'role' => 'Лице за заштитено внатрешно пријавување', 'email' => 'prijava@kpuidrizovo.gov.mk'],
                ['name' => 'Виолета Тепеѓозова', 'role' => 'Раководител на одделение за човечки ресурси', 'email' => 'violeta.tepegozova@kpuidrizovo.gov.mk'],
                ['name' => 'Владимир Арсковски', 'role' => 'Раководител на сектор за општи-правни работи и јавни набавки', 'email' => 'vladimirarskovski@gmail.com'],
                ['name' => 'Африм Незири', 'role' => 'Раководител на сектор за ресоцијализација', 'email' => 'kpuidrizovo@kpuidrizovo.gov.mk'],
                ['name' => 'Цветков Љупчо', 'role' => 'Помошник раководител во сектор за ресоцијализација', 'email' => 'ljupco.cvetkov73@gmail.com'],
                ['name' => 'Марија Цветкова', 'role' => 'Раководител во отворено одделение Велес', 'email' => 'otvorenooddelenieveles@yahoo.com'],
                ['name' => 'Игор Кокалински', 'role' => 'Заповедник во затворска полиција', 'email' => ''],
            ],
            'mission' => 'Да обезбедиме безбедна, хумана и ефикасна казнено-поправна услуга што придонесува во ресоцијализација на затворениците и намалување на повторно криминално однесување.',
            'vision' => 'Казнено-поправна установа што е препозната по својата посветеност на човечност, правди и развој на затворениците во зајакнување на правната држава и мирот во заедницата.',
            'regulation' => [
                'subtitle' => 'Правилник за куќен ред и работа на КПУ КПД Идризово',
                'text' => 'Правилникот ги уредува односите, однесувањето и начинот на функционирање на установата во согласност со законските прописи.',
                'pdf' => 'documents/pravilnik.pdf',
            ],
            'quick_info' => [
                'year' => '1998',
                'capacity' => '450',
                'address' => 'Идризово, Скопје',
            ],
            'sectors' => [
                ['img' => 'dokumenti.png', 'name' => 'СЕКТОР ЗА РЕСОЦИЈАЛИЗАЦИЈА', 'sub' => ['1. Одделение за прием', '2. Одделение за третман', '3. Одделение за стручно инструкторски работи']],
                ['img' => 'dokumenti.png', 'name' => 'СЕКТОР ЗА ОПШТИ-ПРАВНИ РАБОТИ', 'sub' => ['1. Одделение за општи-правни работи', '2. Одделение за јавни набавки']],
                ['img' => 'dokumenti.png', 'name' => 'СЕКТОР ЗА ФИНАНСИСКИ ПРАШАЊА', 'sub' => ['1. Буџетска координација', '2. Сметководство']],
                ['img' => 'dokumenti.png', 'name' => 'ОДДЕЛЕНИЕ ЗА ЧОВЕЧКИ РЕСУРСИ', 'sub' => ['1. Буџетска координација', '2. Сметководство']],
                ['img' => 'dokumenti.png', 'name' => 'ОТВОРЕНО ОДДЕЛЕНИЕ ВЕЛЕС', 'sub' => ['1. Буџетска координација', '2. Сметководство']],
                ['img' => 'dokumenti.png', 'name' => 'СЕКТОР НА ЗАТВОРСКА ПОЛИЦИЈА', 'sub' => ['1. Буџетска координација', '2. Сметководство']],
            ],
        ];
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{name: string, role: string, email: string}>
     */
    private function normalizeOfficers(array $rows): array
    {
        $out = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));

            if ($name === '') {
                continue;
            }

            $out[] = [
                'name' => $name,
                'role' => trim((string) ($row['role'] ?? '')),
                'email' => trim((string) ($row['email'] ?? '')),
            ];
        }

        return array_values($out);
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{img: string, name: string, sub: array<int, string>}>
     */
    private function normalizeSectors(array $rows, Request $request, array $defaults = []): array
    {
        $out = [];

        foreach ($rows as $index => $row) {
            if (! is_array($row)) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));

            if ($name === '') {
                continue;
            }

            $lines = preg_split('/\r\n|\r|\n/', (string) ($row['subs_text'] ?? ''));
            $sub = [];

            if (is_array($lines)) {
                foreach ($lines as $line) {
                    $t = trim((string) $line);

                    if ($t !== '') {
                        $sub[] = $t;
                    }
                }
            }

            $out[] = [
                'img' => $this->resolveStoredImage(
                    $request->file('sectors.' . $index . '.img_file'),
                    (string) ($row['img_current'] ?? ''),
                    'aboutus/sectors',
                    $defaults[$index]['img'] ?? 'images/dokumenti.png'
                ),
                'name' => $name,
                'sub' => $sub,
            ];
        }
        return array_values($out);
    }

    public function currentData(): array
    {
        return $this->getAboutData();
    }
}
