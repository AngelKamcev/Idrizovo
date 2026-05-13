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

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1000;
        overflow-y: auto;
        padding: 20px;
    }

    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 15px;
        max-width: 700px;
        width: 100%;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        color: #333;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-close {
        float: right;
        font-size: 28px;
        font-weight: bold;
        color: #0b1426;
        cursor: pointer;
        transition: color 0.2s ease;
        border: none;
        background: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        color: #000;
    }

    .modal-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
        max-height: 400px;
        object-fit: cover;
    }

    .modal-title {
        clear: both;
        font-size: 24px;
        font-weight: 700;
        color: #0b1426;
        margin: 15px 0;
        line-height: 1.3;
    }

    .modal-body {
        font-size: 14px;
        line-height: 1.6;
        color: #333;
        white-space: pre-wrap;
        word-wrap: break-word;
    }


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
            
            <?php if($announcements->count() > 0): ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-4">
                        
                        <?php $firstAnnouncement = $announcements->first(); ?>
                        <div class="glass-card p-6 flex flex-col gap-5 h-full">
                            <div>
                                <h3 class="text-[15px] text-white font-bold mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                    <?php echo e($firstAnnouncement->getTranslation('title', app()->getLocale())); ?>

                                </h3>
                                <p class="text-[12px] text-white/80 leading-relaxed">
                                    <?php echo e(Str::limit($firstAnnouncement->getTranslation('content', app()->getLocale()), 150)); ?>

                                </p>
                            </div>
                            <button class="btn-more w-fit mt-auto view-more-btn" 
                                    data-announcement-title="<?php echo e($firstAnnouncement->getTranslation('title', app()->getLocale())); ?>" 
                                    data-announcement-content="<?php echo e($firstAnnouncement->getTranslation('content', app()->getLocale())); ?>"
                                    data-announcement-image="<?php echo e($firstAnnouncement->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                        </div>

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                            <?php $__currentLoopData = $announcements->slice(1, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                    <div>
                                        <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                            <?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>

                                        </h3>
                                        <p class="text-[12px] text-white/80 leading-relaxed">
                                            <?php echo e(Str::limit($announcement->getTranslation('content', app()->getLocale()), 80)); ?>

                                        </p>
                                    </div>
                                    <button class="btn-more w-fit mt-auto view-more-btn" 
                                            data-announcement-title="<?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>" 
                                            data-announcement-content="<?php echo e($announcement->getTranslation('content', app()->getLocale())); ?>"
                                            data-announcement-image="<?php echo e($announcement->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                            <?php $__currentLoopData = $announcements->slice(3, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                    <div>
                                        <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                            <?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>

                                        </h3>
                                        <p class="text-[12px] text-white/80 leading-relaxed">
                                            <?php echo e(Str::limit($announcement->getTranslation('content', app()->getLocale()), 80)); ?>

                                        </p>
                                    </div>
                                    <button class="btn-more w-fit mt-auto view-more-btn" 
                                            data-announcement-title="<?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>" 
                                            data-announcement-content="<?php echo e($announcement->getTranslation('content', app()->getLocale())); ?>"
                                            data-announcement-image="<?php echo e($announcement->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <?php if($announcements->count() > 5): ?>
                            <?php $lastLatest = $announcements->slice(5, 1)->first(); ?>
                            <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                <div>
                                    <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                        <?php echo e($lastLatest->getTranslation('title', app()->getLocale())); ?>

                                    </h3>
                                    <p class="text-[12px] text-white/80 leading-relaxed">
                                        <?php echo e(Str::limit($lastLatest->getTranslation('content', app()->getLocale()), 80)); ?>

                                    </p>
                                </div>
                                <button class="btn-more w-fit mt-auto view-more-btn" 
                                        data-announcement-title="<?php echo e($lastLatest->getTranslation('title', app()->getLocale())); ?>" 
                                        data-announcement-content="<?php echo e($lastLatest->getTranslation('content', app()->getLocale())); ?>"
                                        data-announcement-image="<?php echo e($lastLatest->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="glass-card p-6 text-center">
                    <p class="text-white">Нема соопштенија во моментов.</p>
                </div>
            <?php endif; ?>
        </section>

        <!-- ПОСТАРИ СООПШТЕНИЈА -->
        <?php if($announcements->count() > 6): ?>
            <section class="mb-0 relative z-20">
                <h2 class="text-xl font-bold mb-5 text-white/90"><?php echo e(__('older_announcements')); ?></h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-4">
                        
                        <?php $firstOlder = $announcements->slice(6, 1)->first(); ?>
                        <?php if($firstOlder): ?>
                            <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                <div>
                                    <h3 class="text-[15px] text-white font-bold mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                        <?php echo e($firstOlder->getTranslation('title', app()->getLocale())); ?>

                                    </h3>
                                    <p class="text-[12px] text-white/80 leading-relaxed">
                                        <?php echo e(Str::limit($firstOlder->getTranslation('content', app()->getLocale()), 150)); ?>

                                    </p>
                                </div>
                                <button class="btn-more w-fit mt-auto view-more-btn" 
                                        data-announcement-title="<?php echo e($firstOlder->getTranslation('title', app()->getLocale())); ?>" 
                                        data-announcement-content="<?php echo e($firstOlder->getTranslation('content', app()->getLocale())); ?>"
                                        data-announcement-image="<?php echo e($firstOlder->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                            </div>
                        <?php endif; ?>

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                            <?php $__currentLoopData = $announcements->slice(7, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                    <div>
                                        <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                            <?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>

                                        </h3>
                                        <p class="text-[12px] text-white/80 leading-relaxed">
                                            <?php echo e(Str::limit($announcement->getTranslation('content', app()->getLocale()), 80)); ?>

                                        </p>
                                    </div>
                                    <button class="btn-more w-fit mt-auto view-more-btn" 
                                            data-announcement-title="<?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>" 
                                            data-announcement-content="<?php echo e($announcement->getTranslation('content', app()->getLocale())); ?>"
                                            data-announcement-image="<?php echo e($announcement->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-full">
                            <?php $__currentLoopData = $announcements->slice(9, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                    <div>
                                        <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                            <?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>

                                        </h3>
                                        <p class="text-[12px] text-white/80 leading-relaxed">
                                            <?php echo e(Str::limit($announcement->getTranslation('content', app()->getLocale()), 80)); ?>

                                        </p>
                                    </div>
                                    <button class="btn-more w-fit mt-auto view-more-btn" 
                                            data-announcement-title="<?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>" 
                                            data-announcement-content="<?php echo e($announcement->getTranslation('content', app()->getLocale())); ?>"
                                            data-announcement-image="<?php echo e($announcement->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <?php if($announcements->count() > 11): ?>
                            <?php $lastOlder = $announcements->slice(11, 1)->first(); ?>
                            <div class="glass-card p-6 flex flex-col gap-5 h-full">
                                <div>
                                    <h3 class="text-[15px] font-bold text-white mb-4 underline decoration-[2px] underline-offset-4 decoration-white/40 leading-relaxed">
                                        <?php echo e($lastOlder->getTranslation('title', app()->getLocale())); ?>

                                    </h3>
                                    <p class="text-[12px] text-white/80 leading-relaxed">
                                        <?php echo e(Str::limit($lastOlder->getTranslation('content', app()->getLocale()), 80)); ?>

                                    </p>
                                </div>
                                <button class="btn-more w-fit mt-auto view-more-btn" 
                                        data-announcement-title="<?php echo e($lastOlder->getTranslation('title', app()->getLocale())); ?>" 
                                        data-announcement-content="<?php echo e($lastOlder->getTranslation('content', app()->getLocale())); ?>"
                                        data-announcement-image="<?php echo e($lastOlder->getImageUrl() ?? ''); ?>"><?php echo e(__('view_more')); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div>
</main>

<!-- MODAL FOR ANNOUNCEMENT DETAILS -->
<div id="announcementModal" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" id="closeModal">&times;</button>
        <div id="modalImage"></div>
        <h2 class="modal-title" id="modalTitle"></h2>
        <div class="modal-body" id="modalContent"></div>
    </div>
</div>

<script>
    const modal = document.getElementById('announcementModal');
    const closeBtn = document.getElementById('closeModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    const viewMoreBtns = document.querySelectorAll('.view-more-btn');

    // Open modal when clicking view more button
    viewMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const title = this.dataset.announcementTitle;
            const content = this.dataset.announcementContent;
            const imageUrl = this.dataset.announcementImage;

            // Set modal content
            modalTitle.textContent = title;
            modalContent.textContent = content;

            // Set image if exists
            if (imageUrl) {
                modalImage.innerHTML = '<img src="' + imageUrl + '" alt="' + title + '" class="modal-image">';
            } else {
                modalImage.innerHTML = '';
            }

            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal
    function closeModalFunc() {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    closeBtn.addEventListener('click', closeModalFunc);

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModalFunc();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModalFunc();
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\Idrizovo\Idrizovo\backend\resources\views/soopstenija.blade.php ENDPATH**/ ?>