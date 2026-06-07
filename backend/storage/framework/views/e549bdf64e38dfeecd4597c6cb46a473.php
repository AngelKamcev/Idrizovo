<?php
    $resolveUrl = function (?string $u): string {
        $u = (string) $u;
        if ($u === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $u)) {
            return $u;
        }
        if (str_starts_with($u, '/storage/') || str_starts_with($u, 'storage/')) {
            return asset(ltrim($u, '/'));
        }
        if (preg_match('#^(images|documents)/#', $u)) {
            return asset($u);
        }

        return asset('storage/'.ltrim($u, '/'));
    };
    $strips = $section['strip_images'] ?? [];
    $strips = array_values(array_filter($strips, fn ($s) => is_string($s) && $s !== ''));
?>

<?php if(($section['layout'] ?? '') === 'images_left'): ?>
<section class="py-16 hidden md:block">
    <div class="py-16">
        <div class="max-w-7xl mx-auto flex items-center gap-12 px-6">
            <div class="flex items-center">
                <div class="relative z-10">
                    <img src="<?php echo e($resolveUrl($section['main_image'] ?? '')); ?>" alt="" class="w-[420px] h-[420px] object-cover rounded-2xl shadow-lg" />
                </div>
                <div class="flex -ml-16">
                    <?php $__currentLoopData = array_slice($strips, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group relative <?php echo e(!$loop->first ? '-ml-10' : ''); ?>">
                            <img src="<?php echo e($resolveUrl($strip)); ?>" alt="" class="w-[70px] h-[420px] object-cover rounded-xl shadow-md transition-all duration-500 group-hover:w-[420px] group-hover:ml-4 group-hover:z-50" />
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="max-w-lg">
                <h2 class="text-2xl font-bold mb-4"><?php echo e($section['title'] ?? ''); ?></h2>
                <p class="text-gray-700 leading-relaxed mb-6"><?php echo nl2br(e($section['body'] ?? '')); ?></p>
                <a href="<?php echo e(route('izrabotki.section', $sectionIndex)); ?>" class="inline-block bg-[#0E1B2F] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition"><?php echo e(__('view_more')); ?></a>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
<section class="py-16 hidden md:block">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-2xl font-bold mb-4"><?php echo e($section['title'] ?? ''); ?></h2>
            <p class="text-gray-700 leading-relaxed mb-6"><?php echo nl2br(e($section['body'] ?? '')); ?></p>
            <a href="<?php echo e(route('izrabotki.section', $sectionIndex)); ?>" class="inline-block bg-[#0E1B2F] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition"><?php echo e(__('view_more')); ?></a>
        </div>
        <div class="relative flex items-center justify-end">
            <?php $__currentLoopData = array_slice($strips, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group relative <?php echo e(!$loop->first ? '-ml-10' : ''); ?>">
                    <img src="<?php echo e($resolveUrl($strip)); ?>" alt="" class="w-[70px] h-[420px] object-cover rounded-xl shadow-md transition-all duration-500 group-hover:w-[420px] group-hover:ml-4 group-hover:z-50" />
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="overflow-hidden rounded-2xl shadow-xl w-[320px] h-[420px]">
                <img src="<?php echo e($resolveUrl($section['main_image'] ?? '')); ?>" alt="" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" />
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\Angel\Desktop\idrizovo\Idrizovo\backend\resources\views/partials/izrabotki_desktop_section.blade.php ENDPATH**/ ?>