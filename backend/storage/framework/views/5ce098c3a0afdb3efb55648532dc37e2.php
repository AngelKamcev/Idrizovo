<?php $__env->startSection('title', 'Соопштенија - Идризово'); ?>

<?php $__env->startSection('content'); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');

    html, body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(180deg, #ffffff 0%, #dce5f0 18%, #82a5d4 35%, #5982b6 100%) !important;
        background-attachment: fixed !important;
        min-height: 100vh;
        color: white;
        margin: 0;
        padding: 0;
    }

    * { box-sizing: border-box; }

    .glass-card {
        background: rgba(255, 255, 255, 0.22) !important;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-radius: 15px;
    }

    .btn-more {
        background-color: #0b1426 !important;
        color: #ffffff !important;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 3px;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
        display: inline-block;
    }
    .btn-more:hover { background-color: #000000 !important; }

    .card-title {
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 4px;
        text-decoration-color: rgba(255, 255, 255, 0.6);
        line-height: 1.4;
    }

    .row-span-2 { grid-row: span 2; }

    .logo-wrap {
        position: relative;
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }
    .logo-main {
        display: block;
        width: 100%;
        height: auto;
    }
    .logo-reflection {
        display: block;
        width: 100%;
        height: auto;
        transform: scaleY(-1);
        opacity: 0.85;
        -webkit-mask-image: linear-gradient(to bottom, black 0%, transparent 95%);
        mask-image: linear-gradient(to bottom, black 0%, transparent 95%);
        margin-top: 0;
    }
</style>

<main>
    <div class="max-w-[1150px] mx-auto px-6 pt-10 pb-16">

        <!-- ЛОГО СО РЕФЛЕКСИЈА -->
        <header class="flex flex-col items-center mb-16">
            <div class="logo-wrap">
                <img src="<?php echo e(asset('images/novosti.png')); ?>" alt="Новости" class="logo-main">
                <img src="<?php echo e(asset('images/novosti.png')); ?>" alt="" class="logo-reflection">
            </div>
        </header>

        <!-- НОВИ СООПШТЕНИЈА -->
        <section class="mb-16 relative z-20">
            <h2 class="text-xl font-bold mb-5 text-white/90"><?php echo e(__('latest_announcements')); ?></h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                <div class="flex flex-col gap-4">

                    <div class="glass-card p-6 flex flex-col gap-5 h-full">
                        <div>
                            <h3 class="text-[15px] text-white font-bold mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                <?php echo e(__('news_item_1_title')); ?>

                            </h3>
                            <p class="text-[12px] text-white/80 leading-relaxed">
                                <?php echo e(__('news_item_1_body')); ?>

                            </p>
                        </div>
                        <button class="btn-more w-fit mt-auto"><?php echo e(__('view_more')); ?></button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                        <div class="glass-card p-6 flex flex-col gap-5 h-full">
                            <div>
                                <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                    <?php echo e(__('news_item_3_title')); ?>

                                </h3>
                                <p class="text-[12px] text-white/80 leading-relaxed">
                                    <?php echo e(__('news_item_3_body')); ?>

                                </p>
                            </div>
                            <button class="btn-more w-fit mt-auto"><?php echo e(__('view_more')); ?></button>
                        </div>

                        <div class="glass-card p-6 flex flex-col gap-5 h-full">
                            <div>
                                <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                    <?php echo e(__('news_item_2_title')); ?>

                                </h3>
                                <p class="text-[12px] text-white/80 leading-relaxed">
                                    <?php echo e(__('news_item_2_body')); ?>

                                </p>
                            </div>
                            <button class="btn-more w-fit mt-auto"><?php echo e(__('view_more')); ?></button>
                        </div>
                    </div>

                </div>

                <div class="flex flex-col gap-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                        <div class="glass-card p-6 flex flex-col gap-5 h-full">
                            <div>
                                <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                    <?php echo e(__('news_item_4_title')); ?>

                                </h3>
                                <p class="text-[12px] text-white/80 leading-relaxed">
                                    <?php echo e(__('news_item_4_body')); ?>

                                </p>
                            </div>
                            <button class="btn-more w-fit mt-auto"><?php echo e(__('view_more')); ?></button>
                        </div>

                        <div class="glass-card p-6 flex flex-col gap-5 h-full">
                            <div>
                                <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                    <?php echo e(__('news_item_5_title')); ?>

                                </h3>
                                <p class="text-[12px] text-white/80 leading-relaxed">
                                    <?php echo e(__('news_item_5_body')); ?>

                                </p>
                            </div>
                            <button class="btn-more w-fit mt-auto"><?php echo e(__('view_more')); ?></button>
                        </div>
                    </div>

                    <div class="glass-card p-6 flex flex-col gap-5 h-full">
                        <div>
                            <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                <?php echo e(__('news_item_2_title')); ?>

                            </h3>
                            <p class="text-[12px] text-white/80 leading-relaxed">
                                <?php echo e(__('news_item_2_body')); ?>

                            </p>
                        </div>
                        <button class="btn-more w-fit mt-auto"><?php echo e(__('view_more')); ?></button>
                    </div>

                </div>

            </div>
        </section>

        <!-- ПОСТАРИ СООПШТЕНИЈА -->
        <section class="mb-0 relative z-20">
            <h2 class="text-xl font-bold mb-5 text-white/90"><?php echo e(__('older_announcements')); ?></h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div class="col-span-1 glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white/90 uppercase mb-3 card-title"><?php echo e(__('news_item_5_title')); ?></h3>
                        <p class="text-[11px] text-white/80 leading-relaxed mb-6">Врз основа на член 78 и член 19 од Законот за извршување на санкции (Службен весник на Република Македонија бр 99/19 и 220/19)...</p>
                    </div>
                    <button class="btn-more w-fit"><?php echo e(__('view_more')); ?></button>
                </div>

                <div class="col-span-1 glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white/90 uppercase mb-3 card-title"><?php echo e(__('news_item_1_title')); ?></h3>
                        <p class="text-[11px] text-white/80 leading-relaxed mb-6">Врз основа на член 35 став 1 и член 2 став 5, а во врска член 49 од Законот за административни службеници (Службен...</p>
                    </div>
                    <button class="btn-more w-fit"><?php echo e(__('view_more')); ?></button>
                </div>

                <div class="col-span-1 md:col-span-2 glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white/90 uppercase mb-3 card-title"><?php echo e(__('news_item_6_title')); ?></h3>
                        <p class="text-[11px] text-white/80 leading-relaxed mb-6"><?php echo e(__('news_item_6_body')); ?></p>
                    </div>
                    <button class="btn-more w-fit"><?php echo e(__('view_more')); ?></button>
                </div>

                <div class="col-span-1 md:col-span-2 glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white/90 uppercase mb-3 card-title"><?php echo e(__('news_item_5_title')); ?></h3>
                        <p class="text-[11px] text-white/80 leading-relaxed mb-6">Врз основа на член 52 став 1 и став 2 од Законот за извршување санкции (Службен весник на РМ бр 99/19 и 220/19)...</p>
                    </div>
                    <button class="btn-more w-fit"><?php echo e(__('view_more')); ?></button>
                </div>

                <div class="col-span-1 glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white/90 uppercase mb-3 card-title"><?php echo e(__('news_item_6_title')); ?></h3>
                        <p class="text-[11px] text-white/80 leading-relaxed mb-6">Број на оглас 04/20...</p>
                    </div>
                    <button class="btn-more w-fit mt-4"><?php echo e(__('view_more')); ?></button>
                </div>

                <div class="col-span-1 glass-card p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white/90 uppercase mb-3 card-title"><?php echo e(__('news_item_4_title')); ?></h3>
                        <p class="text-[11px] text-white/80 leading-relaxed mb-6">Врз основа на член 70...</p>
                    </div>
                    <button class="btn-more w-fit mt-4"><?php echo e(__('view_more')); ?></button>
                </div>

            </div>
        </section>

    </div>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/soopstenija.blade.php ENDPATH**/ ?>