<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

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
            'director_image' => ['required', 'string', 'max:255'],
            'deputy_name' => ['required', 'string', 'max:255'],
            'deputy_title' => ['required', 'string', 'max:255'],
            'deputy_image' => ['required', 'string', 'max:255'],
            'officers' => ['required', 'array', 'min:1'],
            'officers.*.name' => ['required', 'string', 'max:255'],
            'officers.*.role' => ['required', 'string', 'max:255'],
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

        SystemSetting::updateOrCreate(
            ['setting_key' => self::SETTING_KEY],
            [
                'value' => json_encode([
                    'history' => [
                        'p1' => $validated['history_p1'],
                        'p2' => $validated['history_p2'],
                    ],
                    'management' => [
                        [
                            'name' => $validated['director_name'],
                            'title' => $validated['director_title'],
                            'image' => $validated['director_image'],
                        ],
                        [
                            'name' => $validated['deputy_name'],
                            'title' => $validated['deputy_title'],
                            'image' => $validated['deputy_image'],
                        ],
                    ],
                    'responsible_officers' => array_values(array_map(function ($row) {
                        return [
                            'name' => trim($row['name']),
                            'role' => trim($row['role']),
                            'email' => trim($row['email'] ?? ''),
                        ];
                    }, $validated['officers'])),
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
        ];
    }

    public function currentData(): array
    {
        return $this->getAboutData();
    }
}
