<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ActivitiesSeeder extends Seeder
{
  private const ASSETS_DIR = 'database/seeders/assets/activities';

  public function run(): void
  {
    $this->ensureAssetsExist();

    $activities = [
      [
        'slug' => 'chess',
        'sort_order' => 1,
        'title' => [
          'mk' => 'Натпревар во шах',
          'en' => 'Chess Tournament',
          'sq' => 'Turneu i Shahut',
        ],
        'description' => [
          'mk' => 'Шаховски турнир кој поттикнува фокус, стратегиско размислување и позитивна интеракција.',
          'en' => 'A chess tournament that encourages focus, strategic thinking and positive interaction.',
          'sq' => 'Një turne shahu që nxit fokus, mendim strategjik dhe ndërveprim pozitiv.',
        ],
      ],
      [
        'slug' => 'welding',
        'sort_order' => 2,
        'title' => [
          'mk' => 'Заварување',
          'en' => 'Welding',
          'sq' => 'Saldim',
        ],
        'description' => [
          'mk' => 'Заварување при кое учесниците учат безбедно да спојуваат метал.',
          'en' => 'Welding activities where participants learn to join metal safely.',
          'sq' => 'Aktivitete saldimi ku pjesëmarrësit mësojnë të bashkojnë metalin në mënyrë të sigurt.',
        ],
      ],
      [
        'slug' => 'carving',
        'sort_order' => 3,
        'title' => [
          'mk' => 'Резба',
          'en' => 'Carving',
          'sq' => 'Gdhendje',
        ],
        'description' => [
          'mk' => 'Рачно изработени резби создадени со внимание и вештина.',
          'en' => 'Hand-crafted carvings created with care and skill.',
          'sq' => 'Gdhendje të bëra me dorë të krijuara me kujdes dhe aftësi.',
        ],
      ],
      [
        'slug' => 'carpentry',
        'sort_order' => 4,
        'title' => [
          'mk' => 'Столарија',
          'en' => 'Carpentry',
          'sq' => 'Zdrukthtari',
        ],
        'description' => [
          'mk' => 'Занаетчиска работа со дрво за создавање и конструирање.',
          'en' => 'Woodworking craft for creating and building.',
          'sq' => 'Punë me dru për krijim dhe ndërtim.',
        ],
      ],
      [
        'slug' => 'electrical',
        'sort_order' => 5,
        'title' => [
          'mk' => 'Електрика',
          'en' => 'Electrical Work',
          'sq' => 'Punë elektrike',
        ],
        'description' => [
          'mk' => 'Обука и извршување на електрични задачи.',
          'en' => 'Training and performing electrical tasks.',
          'sq' => 'Trajnim dhe kryerje e detyrave elektrike.',
        ],
      ],
      [
        'slug' => 'embroidery',
        'sort_order' => 6,
        'title' => [
          'mk' => 'Везење',
          'en' => 'Embroidery',
          'sq' => 'Qëndisje',
        ],
        'description' => [
          'mk' => 'Везење што развива трпение, прецизност и креативност.',
          'en' => 'Embroidery that builds patience, precision and creativity.',
          'sq' => 'Qëndisje që ndërton durim, saktësi dhe kreativitet.',
        ],
      ],
      [
        'slug' => 'drawing',
        'sort_order' => 7,
        'title' => [
          'mk' => 'Цртање',
          'en' => 'Drawing',
          'sq' => 'Vizatim',
        ],
        'description' => [
          'mk' => 'Цртање што ја отвора имагинацијата и внатрешниот мир.',
          'en' => 'Drawing that opens imagination and inner calm.',
          'sq' => 'Vizatimi që hap imagjinatën dhe qetësinë e brendshme.',
        ],
      ],
      [
        'slug' => 'sewing',
        'sort_order' => 8,
        'title' => [
          'mk' => 'Шиење',
          'en' => 'Sewing',
          'sq' => 'Qepje',
        ],
        'description' => [
          'mk' => 'Шиење и практична изработка со фокус и дисциплина.',
          'en' => 'Sewing and practical crafting with focus and discipline.',
          'sq' => 'Qepje dhe punim praktik me fokus dhe disiplinë.',
        ],
      ],
      [
        'slug' => 'painting',
        'sort_order' => 9,
        'title' => [
          'mk' => 'Сликање',
          'en' => 'Painting',
          'sq' => 'Pikturë',
        ],
        'description' => [
          'mk' => 'Сликање како начин за изразување и креативна слобода.',
          'en' => 'Painting as a way of expression and creative freedom.',
          'sq' => 'Piktura si mënyrë shprehjeje dhe lirie krijuese.',
        ],
      ],
      [
        'slug' => 'sports',
        'sort_order' => 10,
        'title' => [
          'mk' => 'Спорт',
          'en' => 'Sports',
          'sq' => 'Sport',
        ],
        'description' => [
          'mk' => 'Физички активности за здравје, тимска работа и благосостојба.',
          'en' => 'Physical activities for health, teamwork and well-being.',
          'sq' => 'Aktivitete fizike për shëndet, punë në ekip dhe mirëqenie.',
        ],
      ],
    ];

    Activity::query()->delete();

    foreach ($activities as $item) {
      $source = base_path(self::ASSETS_DIR . '/' . $item['slug'] . '.jpg');
      $storagePath = 'activities/' . $item['slug'] . '.jpg';

      Storage::disk('public')->put($storagePath, File::get($source));

      $activity = new Activity([
        'image_path' => $storagePath,
        'sort_order' => $item['sort_order'],
        'is_active' => true,
      ]);

      foreach (['mk', 'en', 'sq'] as $locale) {
        $activity->setTranslation('title', $locale, $item['title'][$locale]);
        $activity->setTranslation('description', $locale, $item['description'][$locale]);
      }

      $activity->save();
    }

    Cache::forget('all_activities');
    foreach (['mk', 'en', 'sq'] as $locale) {
      Cache::forget('home_activities_' . $locale);
    }
  }

  private function ensureAssetsExist(): void
  {
    $assetsDir = base_path(self::ASSETS_DIR);

    if (! is_dir($assetsDir)) {
      throw new \RuntimeException('Missing activity seed assets directory: '.$assetsDir);
    }

    $required = [
      'chess', 'welding', 'carving', 'carpentry', 'electrical',
      'embroidery', 'drawing', 'sewing', 'painting', 'sports',
    ];

    foreach ($required as $slug) {
      if (! is_file($assetsDir.'/'.$slug.'.jpg')) {
        throw new \RuntimeException("Missing seed image: {$slug}.jpg — run php database/seeders/assets/activities/download_seed_images.php");
      }
    }
  }
}
