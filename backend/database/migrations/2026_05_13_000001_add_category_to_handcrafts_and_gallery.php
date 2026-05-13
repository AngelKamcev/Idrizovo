<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add category_slug to handcrafts so each record belongs to one of the 4 fixed categories
        Schema::table('handcrafts', function (Blueprint $table) {
            $table->string('category_slug', 50)->default('igla-konec')->after('id');
            $table->string('cover_image_url', 500)->nullable()->after('image_url');
        });

        // Add handcraft_category to gallery so gallery images can be filtered by category
        Schema::table('gallery', function (Blueprint $table) {
            $table->string('handcraft_category', 50)->nullable()->after('category_id');
        });

        // Seed the 4 fixed handcraft categories with placeholder data
        $adminId = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->value('users.id') ?? 1;

        $categories = [
            [
                'slug'        => 'igla-konec',
                'title_mk'   => 'Уметност со игла и конец',
                'title_en'   => 'Needle and Thread Art',
                'title_al'   => 'Arti me gjilpërë dhe fill',
                'desc_mk'    => 'Во затворската работилница, конецот и иглата стануваат повеќе од алатки – тие се мост кон внатрешна слобода. Затворениците со трпеливи движења плетат ташни и кошули, секој бод е чекор кон дисциплина и самоконтрола.',
                'desc_en'    => 'In the prison workshop, thread and needle become more than tools — they are a bridge to inner freedom.',
                'desc_al'    => 'Në punëtorinë e burgut, fija dhe gjilpëra bëhen më shumë se mjete.',
            ],
            [
                'slug'        => 'drvorez',
                'title_mk'   => 'Дрворез',
                'title_en'   => 'Wood Carving',
                'title_al'   => 'Gdhendja e drurit',
                'desc_mk'    => 'Во затворската работилница, дрвото станува средство за тишина, фокус и внатрешна трансформација. Затвореникот преку трпеливо резбање создава сцени од библиски митови, природата или сопствените сеќавања.',
                'desc_en'    => 'In the prison workshop, wood becomes a medium for silence, focus and inner transformation.',
                'desc_al'    => 'Në punëtorinë e burgut, druri bëhet mjet për heshtje dhe transformim.',
            ],
            [
                'slug'        => 'slikarstvo',
                'title_mk'   => 'Боја и перспектива: слики од работилницата',
                'title_en'   => 'Colour and Perspective: Workshop Paintings',
                'title_al'   => 'Ngjyra dhe perspektivë: piktura nga punëtoria',
                'desc_mk'    => 'Во затворот, хартијата и боите стануваат прозорец кон слобода. Затворениците цртаат пејзажи, куќи, дрвја и небо — сцени што ги потсетуваат на светот надвор, но и на светот во нив.',
                'desc_en'    => 'In prison, paper and colours become a window to freedom.',
                'desc_al'    => 'Në burg, letra dhe ngjyrat bëhen dritare drejt lirisë.',
            ],
            [
                'slug'        => 'grncharstvo',
                'title_mk'   => 'Грнчарство',
                'title_en'   => 'Pottery',
                'title_al'   => 'Poçaria',
                'desc_mk'    => 'Во тишината на затворската работилница, глината станува глас. Грнчарството овде не е само занает – тоа е процес на преобразба. Осудените лица преку грнчарството учат да создаваат, а не да уништуваат.',
                'desc_en'    => 'In the silence of the prison workshop, clay becomes a voice.',
                'desc_al'    => 'Në heshtjen e punëtorisë, balta bëhet zë.',
            ],
        ];

        foreach ($categories as $cat) {
            // Only insert if no record with this slug exists yet
            $exists = DB::table('handcrafts')->where('category_slug', $cat['slug'])->exists();
            if (!$exists) {
                DB::table('handcrafts')->insert([
                    'category_slug'  => $cat['slug'],
                    'title_mk'       => $cat['title_mk'],
                    'title_en'       => $cat['title_en'],
                    'title_al'       => $cat['title_al'],
                    'description_mk' => $cat['desc_mk'],
                    'description_en' => $cat['desc_en'],
                    'description_al' => $cat['desc_al'],
                    'image_url'      => '',
                    'is_published'   => true,
                    'created_by'     => $adminId,
                    'created_at'     => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->dropColumn('handcraft_category');
        });

        Schema::table('handcrafts', function (Blueprint $table) {
            $table->dropColumn(['category_slug', 'cover_image_url']);
        });
    }
};
