<?php $__env->startSection('title', __('activities')); ?>

<?php $__env->startSection('content'); ?>
<div class="py-12 px-4 md:px-8 lg:px-16">
    <!-- Page Header -->
    <div class="mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4"><?php echo e(__('activities')); ?></h1>
        <p class="text-lg text-gray-600"><?php echo e(__('Explore our institutional activities and programs')); ?></p>
    </div>

    <!-- Language Switcher -->
    <div class="flex justify-center mb-8">
        <?php $__env->startComponent('components.language-switcher'); ?> <?php echo $__env->renderComponent(); ?>
    </div>

    <!-- Activities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden">
                <!-- Activity Image -->
                <?php if($activity->image_url): ?>
                    <div class="h-48 md:h-56 overflow-hidden bg-gray-200">
                        <img src="<?php echo e($activity->image_url); ?>" 
                             alt="<?php echo e($activity->getTranslation('title', app()->getLocale())); ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                <?php endif; ?>

                <!-- Activity Content -->
                <div class="p-6">
                    <!-- Icon -->
                    <?php if($activity->icon): ?>
                        <div class="text-3xl mb-3">
                            <i class="<?php echo e($activity->icon); ?>"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Title (Translated) -->
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                        <?php echo e($activity->getTranslation('title', app()->getLocale())); ?>

                    </h3>

                    <!-- Description (Translated) -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        <?php echo e($activity->getTranslation('description', app()->getLocale())); ?>

                    </p>

                    <!-- Available Languages -->
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <?php $__currentLoopData = ['mk', 'en', 'sq']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($activity->hasTranslation('title', $lang)): ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded">
                                    <?php switch($lang):
                                        case ('mk'): ?>
                                            🇲🇰
                                        <?php break; ?>
                                        <?php case ('en'): ?>
                                            🇬🇧
                                        <?php break; ?>
                                        <?php case ('sq'): ?>
                                            🇦🇱
                                        <?php break; ?>
                                    <?php endswitch; ?>
                                    <?php echo e(strtoupper($lang)); ?>

                                </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Read More Button -->
                    <a href="#" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm">
                        <?php echo e(__('Learn More')); ?>

                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State -->
            <div class="col-span-full text-center py-12">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e(__('no_results')); ?></h3>
                <p class="text-gray-600"><?php echo e(__('No activities available at the moment.')); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($activities->hasPages()): ?>
        <div class="mt-12">
            <?php echo e($activities->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\public\activities.blade.php ENDPATH**/ ?>