<?php $__env->startSection('title', 'За Нас - Идризово'); ?>

<?php $__env->startSection('content'); ?>

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
    <?php
        $resolveImageSrc = function (?string $path, string $defaultFolder = 'images'): string {
            $path = (string) $path;

            if ($path === '') {
                return asset($defaultFolder . '/');
            }

            if (preg_match('/^https?:\/\//i', $path)) {
                return $path;
            }

            if (str_starts_with($path, '/storage/') || str_starts_with($path, 'storage/') || str_starts_with($path, 'images/') || str_starts_with($path, 'documents/')) {
                return asset(ltrim($path, '/'));
            }

            return asset($defaultFolder . '/' . ltrim($path, '/'));
        };
    ?>

    <div class="relative w-full overflow-hidden bg-[#1a3a6b] h-[400px] md:h-[640px]">
        <img class="absolute inset-0 w-full h-full object-cover object-center"
             src="<?php echo e(asset($aboutData['hero_image'] ?? 'images/about_hero.jpeg')); ?>" alt="За Нас">
        <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(10,30,70,0.3) 0%, rgba(10,30,70,0.6) 100%);"></div>

        <div class="absolute top-20 left-6 md:left-28 text-black text-4xl md:text-7xl font-bold tracking-widest uppercase z-10" style="text-shadow:0 2px 8px rgba(0,0,0,0.4);">
            <?php echo e(__('about_title')); ?>

        </div>

        <div class="zanas-tabs absolute bottom-6 left-0 right-0 px-4 md:px-40 flex flex-wrap justify-center md:justify-between items-center gap-2 md:gap-0 z-10">
            <a href="#istorija" class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105" style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);"><?php echo e(__('history')); ?></a>
            <a href="#misija"   class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105" style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);"><?php echo e(__('mission')); ?></a>
            <a href="#vizija"   class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105" style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);"><?php echo e(__('vision')); ?></a>
        </div>
    </div>

    <div id="istorija" class="max-w-[1200px] mx-auto px-6 md:px-10 py-10 md:py-16 flex flex-col md:flex-row items-center gap-10 md:gap-16">
        <div class="flex-shrink-0 w-full md:w-[420px]">
            <img src="<?php echo e(asset($aboutData['history_side_image'] ?? 'images/about_hero.jpeg')); ?>" alt="Историја"
                 class="w-full h-[300px] md:h-[410px] object-cover rounded-2xl block shadow-md">
        </div>
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-[1.6rem] md:text-[1.9rem] font-bold text-[#1a1a1a] mb-5 mt-0"><?php echo e(__('history')); ?></h2>
            <p class="text-[0.95rem] leading-7 text-[#333] mb-4">
                <?php echo e($aboutData['history']['p1'] ?? ''); ?>

            </p>
            <p class="text-[0.95rem] leading-7 text-[#333] mb-6">
                <?php echo e($aboutData['history']['p2'] ?? ''); ?>

            </p>
            <a href="#" class="inline-block text-[#1a1a1a] text-[0.95rem] font-bold underline underline-offset-4 mt-1 hover:text-[#2E589E] transition-colors"><?php echo e(__('read_more')); ?></a>
        </div>
    </div>

    <div id="misija" class="max-w-[1200px] mx-auto px-6 md:px-10 py-10 md:py-16 flex flex-col md:flex-row-reverse items-center gap-10 md:gap-16">
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-[1.6rem] md:text-[1.9rem] font-bold text-[#1a1a1a] mb-5 mt-0"><?php echo e(__('mission')); ?></h2>
            <p class="text-[0.95rem] leading-7 text-[#333] mb-4 whitespace-pre-line"><?php echo e($aboutData['mission'] ?? ''); ?></p>
        </div>
    </div>

    <div id="vizija" class="max-w-[1200px] mx-auto px-6 md:px-10 py-10 md:py-16 flex flex-col md:flex-row items-center gap-10 md:gap-16">
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-[1.6rem] md:text-[1.9rem] font-bold text-[#1a1a1a] mb-5 mt-0"><?php echo e(__('vision')); ?></h2>
            <p class="text-[0.95rem] leading-7 text-[#333] mb-4 whitespace-pre-line"><?php echo e($aboutData['vision'] ?? ''); ?></p>
        </div>
    </div>

    

    <div id="uprava" class="max-w-[1200px] mx-auto px-6 md:px-10 pt-4 pb-12 mt-10 md:mt-20">
        <h2 class="text-[1.4rem] font-bold text-[#1a2a4a] mb-10 text-center md:text-left"><?php echo e(__('management')); ?></h2>
        <div class="flex flex-col md:flex-row flex-wrap justify-center items-center md:items-start gap-12 md:gap-32">
            <?php $__currentLoopData = $aboutData['management'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex flex-col items-center">
                    <img src="<?php echo e($resolveImageSrc($member['image'] ?? 'direktor.png')); ?>"
                         class="w-[240px] md:w-[260px] h-[260px] md:h-[280px] object-cover object-top rounded-2xl shadow-sm block">
                    <p class="text-[1rem] font-bold text-[#1a1a1a] mt-4 text-center leading-snug"><?php echo e($member['name'] ?? ''); ?></p>
                    <p class="text-[0.7rem] text-[#888] text-center mt-1 tracking-widest font-medium uppercase"><?php echo e($member['title'] ?? ''); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div id="odgovorni" class="max-w-[1100px] mx-auto px-6 pb-20 mt-10 md:mt-20">
        <h2 class="text-[1.4rem] md:text-[1.6rem] font-bold text-black mb-12 text-center"><?php echo e(__('responsible_officers')); ?></h2>
        <div class="flex flex-wrap gap-6 justify-center">
            <?php $__currentLoopData = $aboutData['responsible_officers'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-[#6691D2] text-white rounded-2xl p-6 md:p-8 text-center flex flex-col justify-center items-center shadow-sm w-full md:w-[320px] min-h-[180px]">
                    <p class="text-[1rem] font-semibold mb-3 leading-tight"><?php echo e($item['name'] ?? ''); ?></p>
                    <p class="text-[0.65rem] font-medium opacity-100 leading-normal mb-4 tracking-wide uppercase"><?php echo e($item['role'] ?? ''); ?></p>
                    <?php if(!empty($item['email'])): ?>
                        <div class="flex items-center justify-center space-x-2 mt-auto">
                            <span class="text-[0.75rem] lowercase opacity-90 break-all"><?php echo e($item['email']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div id="pravilnik" class="max-w-[1100px] mx-auto px-6 py-12 md:py-20 text-center">
        <h2 class="text-[1.5rem] md:text-[1.8rem] font-bold text-black mb-4 tracking-tight uppercase"><?php echo e(__('regulation')); ?></h2>
        <h3 class="text-[1rem] md:text-[1.25rem] font-bold text-black mb-10 max-w-[900px] mx-auto leading-tight">
            <?php echo e($aboutData['regulation']['subtitle'] ?? ''); ?>

        </h3>
        <p class="text-[0.95rem] text-black leading-[1.8] mb-10 max-w-[950px] mx-auto font-normal">
            <?php echo e($aboutData['regulation']['text'] ?? ''); ?>

        </p>
            <a href="<?php echo e(asset($aboutData['regulation']['pdf'] ?? 'documents/pravilnik.pdf')); ?>" target="_blank" class="inline-block bg-[#0F1C2E] hover:bg-black text-white text-[0.8rem] md:text-[0.9rem] font-bold px-10 md:px-12 py-3 md:py-3.5 rounded-md transition-all no-underline shadow-md"><?php echo e(__('download')); ?></a>
    </div>

    <div id="sektori" class="section-sektori relative px-6 py-16 md:py-[100px] overflow-hidden" 
         style="background: linear-gradient(180deg, #5179B9 0%, #79A3D9 50%, #BDD4F0 100%);">
        <h2 class="relative z-[2] max-w-[1100px] mx-auto mb-16 text-[1.8rem] md:text-[2.2rem] font-bold text-[#1a2a4a] text-center md:text-left"><?php echo e(__('sectors')); ?></h2>
        <div class="relative z-[2] max-w-[1100px] mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-16 md:gap-x-8">
            <?php $__currentLoopData = $aboutData['sectors'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sektor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex flex-col items-center">
                    <div class="h-[120px] md:h-[150px] w-full flex items-center justify-center mb-[-40px] relative z-10">
                        <img src="<?php echo e($resolveImageSrc($sektor['img'] ?? 'dokumenti.png')); ?>" class="max-h-full object-contain drop-shadow-xl" alt="">
                    </div>
                    <div class="w-full bg-white/25 border border-white/40 backdrop-blur-lg rounded-[25px] p-6 md:p-8 pt-12 min-h-[200px] md:min-h-[220px] shadow-lg flex flex-col">
                        <h3 class="text-[0.9rem] md:text-[1rem] font-bold text-white leading-tight mb-4"><?php echo e($sektor['name'] ?? ''); ?></h3>
                        <?php if(!empty($sektor['sub']) && is_array($sektor['sub'])): ?>
                            <ul class="text-[0.7rem] md:text-[0.75rem] text-white/90 space-y-1 font-normal list-none p-0 m-0">
                                <?php $__currentLoopData = $sektor['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($sub); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\idrizovo\Idrizovo\backend\resources\views/aboutus.blade.php ENDPATH**/ ?>