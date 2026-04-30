<?php require_once __DIR__ . '/header.php'; ?>

<style>
    /* Само работи кои не можат со Tailwind */
    .zanas-tabs a {
        transition: background 0.2s, opacity 0.2s;
    }
    .zanas-tabs a.active {
        background: rgba(46, 88, 158, 0.95) !important;
        box-shadow: 0 0 0 2px rgba(100,181,246,0.5);
    }
    .zanas-tabs a:hover {
        opacity: 0.85;
    }
    .section-sektori::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 80px;
        background: linear-gradient(to bottom, #ffffff 0%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }
    .section-sektori::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 80px;
        background: linear-gradient(to top, #ffffff 0%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }
</style>

<div class="font-sans text-[#1a2a4a] bg-white overflow-x-hidden">

    <div class="relative w-full overflow-hidden bg-[#1a3a6b] h-[400px] md:h-[640px]">
        <img class="absolute inset-0 w-full h-full object-cover object-center"
             src="sliki/about_hero.jpeg" alt="За Нас">
        <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(10,30,70,0.3) 0%, rgba(10,30,70,0.6) 100%);"></div>

        <div class="absolute top-20 left-6 md:left-28 text-black text-4xl md:text-7xl font-bold tracking-widest uppercase z-10" style="text-shadow:0 2px 8px rgba(0,0,0,0.4);">
            ЗА НАС
        </div>

        <div class="zanas-tabs absolute bottom-6 left-0 right-0 px-4 md:px-40 flex flex-wrap justify-center md:justify-between items-center gap-2 md:gap-0 z-10">
            <a href="#istorija" class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105" style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);">ИСТОРИЈА</a>
            <a href="#misija"   class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105" style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);">МИСИЈА</a>
            <a href="#vizija"   class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105" style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);">ВИЗИЈА</a>
        </div>
    </div>

    <div id="istorija" class="max-w-[1200px] mx-auto px-6 md:px-10 py-10 md:py-16 flex flex-col md:flex-row items-center gap-10 md:gap-16">
        <div class="flex-shrink-0 w-full md:w-[420px]">
            <img src="sliki/about_hero.jpeg" alt="Историја"
                 class="w-full h-[300px] md:h-[410px] object-cover rounded-2xl block shadow-md">
        </div>
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-[1.6rem] md:text-[1.9rem] font-bold text-[#1a1a1a] mb-5 mt-0">Историја</h2>
            <p class="text-[0.95rem] leading-7 text-[#333] mb-4">
                Казнено-Поправниот Дом Идризово е најголемата затворска установа
                во Република С. Македонија. Таа се наоѓа около 10 километри
                југоисточно од Скопје и претставува централна установа за
                издржување затворски казни.
            </p>
            <p class="text-[0.95rem] leading-7 text-[#333] mb-6">
                Историјата на КПД Идризово започнува во текот на Втората светска
                војна, кога е изграден воен камп од страна на бугарската окупаторска
                војска. Веднаш по завршувањето на Втората светска војна продолжува
                да функционира како затвор – работна колонија, каде што
                затворениците биле ангажирани во земјоделски и градежни работи. Со
                текот на времето, установата се проширила и станала најголемиот
                затвор во државата.
            </p>
            <a href="#" class="inline-block text-[#1a1a1a] text-[0.95rem] font-bold underline underline-offset-4 mt-1 hover:text-[#2E589E] transition-colors">Прочитај повеќе</a>
        </div>
    </div>

    <div id="uprava" class="max-w-[1200px] mx-auto px-6 md:px-10 pt-4 pb-12 mt-10 md:mt-20">
        <h2 class="text-[1.4rem] font-bold text-[#1a2a4a] mb-10 text-center md:text-left">Управа</h2>
        <div class="flex flex-col md:flex-row flex-wrap justify-center items-center md:items-start gap-12 md:gap-32">
            <?php
            $uprava_members = array(
                array('image' => 'sliki/about_hero.jpeg', 'name' => 'М-р. Зоран Јовановски', 'title' => 'ДИРЕКТОР'),
                array('image' => 'sliki/about_hero.jpeg', 'name' => 'Наим Љамалари', 'title' => 'ЗАМЕНИК ДИРЕКТОР'),
            );
            foreach ($uprava_members as $member) : ?>
                <div class="flex flex-col items-center">
                    <img src="<?php echo htmlspecialchars($member['image']); ?>" 
                         class="w-[240px] md:w-[260px] h-[260px] md:h-[280px] object-cover object-top rounded-2xl shadow-sm block">
                    <p class="text-[1rem] font-bold text-[#1a1a1a] mt-4 text-center leading-snug"><?php echo htmlspecialchars($member['name']); ?></p>
                    <p class="text-[0.7rem] text-[#888] text-center mt-1 tracking-widest font-medium uppercase"><?php echo htmlspecialchars($member['title']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="odgovorni" class="max-w-[1100px] mx-auto px-6 pb-20 mt-10 md:mt-20">
        <h2 class="text-[1.4rem] md:text-[1.6rem] font-bold text-black mb-12 text-center">Одговорни службени лица</h2>
        <div class="flex flex-wrap gap-6 justify-center">
            <?php
            $odgovorni = array(
                array('name' => 'Разије Османи Хоџа', 'role' => 'ЛИЦЕ ЗА ПОСРЕДУВАЊЕ СО ИНФОРМАЦИИ', 'email' => 'razije@kpuidrizovo.gov.mk'),
                array('name' => 'Горан Јовчевски', 'role' => 'ЛИЦЕ ЗА ЗАШТИТЕНО ВНАТРЕШНО ПРИЈАВУВАЊЕ', 'email' => 'prijava@kpuidrizovo.gov.mk'),
                array('name' => 'Виолета Тепеѓозова', 'role' => 'РАКОВОДИТЕЛ НА ОДДЕЛЕНИЕ ЗА ЧОВЕЧКИ РЕСУРСИ', 'email' => 'violeta.tepegozova@kpuidrizovo.gov.mk'),
                array('name' => 'Владимир Арсковски', 'role' => 'РАКОВОДИТЕЛ НА СЕКТОР ЗА ОПШТО-ПРАВНИ РАБОТИ И ЈАВНИ НАБАВКИ', 'email' => 'vladimirarskovski@gmail.com'),
                array('name' => 'Африм Незири', 'role' => 'РАКОВОДИТЕЛ НА СЕКТОР ЗА РЕСОЦИЈАЛИЗАЦИЈА', 'email' => 'kpuidrizovo@kpuidrizovo.gov.mk'),
                array('name' => 'Цветков Љупчо', 'role' => 'ПОМОШНИК РАКОВОДИТЕЛ ВО СЕКТОР ЗА РЕСОЦИЈАЛИЗАЦИЈА', 'email' => 'ljupco.cvetkov73@gmail.com'),
                array('name' => 'Марија Цветкова', 'role' => 'РАКОВОДИТЕЛ ВО ОТВОРЕНО ОДДЕЛЕНИЕ ВЕЛЕС', 'email' => 'otvorenooddelenieveles@yahoo.com'),
                array('name' => 'Игор Кокалински', 'role' => 'ЗАПОВЕДНИК ВО ЗАТВОРСКА ПОЛИЦИЈА', 'email' => ''),
            );
            foreach ($odgovorni as $item) : ?>
                <div class="bg-[#6691D2] text-white rounded-2xl p-6 md:p-8 text-center flex flex-col justify-center items-center shadow-sm w-full md:w-[320px] min-h-[180px]">
                    <p class="text-[1rem] font-semibold mb-3 leading-tight"><?php echo htmlspecialchars($item['name']); ?></p>
                    <p class="text-[0.65rem] font-medium opacity-100 leading-normal mb-4 tracking-wide uppercase"><?php echo htmlspecialchars($item['role']); ?></p>
                    <?php if (!empty($item['email'])) : ?>
                        <div class="flex items-center justify-center space-x-2 mt-auto">
                            <span class="text-[0.75rem] lowercase opacity-90 break-all"><?php echo htmlspecialchars($item['email']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="pravilnik" class="max-w-[1100px] mx-auto px-6 py-12 md:py-20 text-center">
        <h2 class="text-[1.5rem] md:text-[1.8rem] font-bold text-black mb-4 tracking-tight uppercase">Правилник</h2>
        <h3 class="text-[1rem] md:text-[1.25rem] font-bold text-black mb-10 max-w-[900px] mx-auto leading-tight">
            за внатрешна организација и работа на Казнено-поправната установа Идризово
        </h3>
        <p class="text-[0.95rem] text-black leading-[1.8] mb-10 max-w-[950px] mx-auto font-normal">

        Со овој Правилник се уредува организацијата и работата на Казнено-поправната установа - Казнено-поправниот дом Идризово - со отворено одделение во Велес

        (во понатамошниот текст: Установата), се утврдуваат внатрешната организација, видот на организационите единици и нивниот делокруг на работење, раководење во

        Установата и во организационите единици, програмирањето и извршувањето на работите и задачите во установата.

    </p>
        <a href="documents/pravilnik.pdf" target="_blank" class="inline-block bg-[#0F1C2E] hover:bg-black text-white text-[0.8rem] md:text-[0.9rem] font-bold px-10 md:px-12 py-3 md:py-3.5 rounded-md transition-all no-underline shadow-md">ПРЕВЗЕМИ</a>
    </div>

    <div id="sektori" class="section-sektori relative px-6 py-16 md:py-[100px] overflow-hidden" 
         style="background: linear-gradient(180deg, #5179B9 0%, #79A3D9 50%, #BDD4F0 100%);">
        <h2 class="relative z-[2] max-w-[1100px] mx-auto mb-16 text-[1.8rem] md:text-[2.2rem] font-bold text-[#1a2a4a] text-center md:text-left">Сектори</h2>
        <div class="relative z-[2] max-w-[1100px] mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-16 md:gap-x-8">
            <?php
            $sektori = array(
                array('img' => 'sliki/dokumenti.png', 'name' => 'СЕКТОР ЗА РЕСОЦИЈАЛИЗАЦИЈА', 'sub' => array('1. Одделение за прием', '2. Одделение за третман', '3. Одделение за стручно инструкторски работи')),
                array('img' => 'sliki/dokumenti.png', 'name' => 'СЕКТОР ЗА ОПШТИ-ПРАВНИ РАБОТИ', 'sub' => array('1. Одделение за општи-правни работи', '2. Одделение за јавни набавки')),
                array('img' => 'sliki/dokumenti.png', 'name' => 'СЕКТОР ЗА ФИНАНСИСКИ ПРАШАЊА', 'sub' => array('1. Буџетска координација', '2. Сметководство')),
                array('img' => 'sliki/dokumenti.png', 'name' => 'ОДДЕЛЕНИЕ ЗА ЧОВЕЧКИ РЕСУРСИ', 'sub' => array('1. Буџетска координација', '2. Сметководство')),
                array('img' => 'sliki/dokumenti.png', 'name' => 'ОТВОРЕНО ОДДЕЛЕНИЕ ВЕЛЕС', 'sub' => array('1. Буџетска координација', '2. Сметководство')),
                array('img' => 'sliki/dokumenti.png', 'name' => 'СЕКТОР НА ЗАТВОРСКА ПОЛИЦИЈА', 'sub' => array('1. Буџетска координација', '2. Сметководство')),
            );
            foreach ($sektori as $sektor) : ?>
                <div class="flex flex-col items-center">
                    <div class="h-[120px] md:h-[150px] w-full flex items-center justify-center mb-[-40px] relative z-10">
                        <img src="<?php echo $sektor['img']; ?>" class="max-h-full object-contain drop-shadow-xl">
                    </div>
                    <div class="w-full bg-white/25 border border-white/40 backdrop-blur-lg rounded-[25px] p-6 md:p-8 pt-12 min-h-[200px] md:min-h-[220px] shadow-lg flex flex-col">
                        <h3 class="text-[0.9rem] md:text-[1rem] font-bold text-white leading-tight mb-4"><?php echo $sektor['name']; ?></h3>
                        <?php if (!empty($sektor['sub'])) : ?>
                            <ul class="text-[0.7rem] md:text-[0.75rem] text-white/90 space-y-1 font-normal list-none p-0 m-0">
                                <?php foreach ($sektor['sub'] as $sub) : ?>
                                    <li><?php echo $sub; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    // Smooth scroll
    document.querySelectorAll('.zanas-tabs a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Active tab on scroll
    var sections = ['istorija', 'misija', 'vizija'];
    window.addEventListener('scroll', function () {
        var scrollY = window.scrollY + 200;
        sections.forEach(function (id) {
            var el = document.getElementById(id);
            if (el && el.offsetTop <= scrollY && (el.offsetTop + el.offsetHeight) > scrollY) {
                document.querySelectorAll('.zanas-tabs a').forEach(function (l) { l.classList.remove('active'); });
                var activeLink = document.querySelector('.zanas-tabs a[href="#' + id + '"]');
                if (activeLink) activeLink.classList.add('active');
            }
        });
    });
</script>

<?php require_once __DIR__ . '/footer.php'; ?>