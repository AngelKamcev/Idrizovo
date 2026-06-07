<?php $__env->startSection('title', 'Галерија'); ?>
<?php $__env->startSection('page-title', 'Галерија'); ?>
<?php $__env->startSection('page-subtitle', 'Качување и уредување на слики (зачувување во база)'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 text-sm"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <a href="<?php echo e(route('admin.gallery.create')); ?>" class="btn-primary">
        <i class="fas fa-upload mr-2"></i> Прикачи слика
    </a>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="group relative rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all bg-gray-100">
            <?php if($image->resolved_url): ?>
                <img src="<?php echo e($image->resolved_url); ?>" alt="<?php echo e($image->adminTitle()); ?>" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
            <?php else: ?>
                <div class="w-full h-48 flex items-center justify-center text-gray-500 text-sm">Нема слика</div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
                <a href="<?php echo e(route('admin.gallery.edit', $image)); ?>" class="btn-edit bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full inline-flex" title="Уреди">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="<?php echo e(route('admin.gallery.destroy', $image)); ?>" method="POST" class="inline" onsubmit="return confirm('Да се избрише сликата?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-danger bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full" title="Избриши">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100">
                <p class="font-semibold truncate"><?php echo e($image->adminTitle()); ?></p>
                <?php if($image->album): ?>
                    <p class="truncate opacity-90"><?php echo e($image->album); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-600 col-span-full">Нема слики. Кликни „Качи слика“ за да додадеш.</p>
    <?php endif; ?>
</div>

<div class="mt-6">
    <?php echo e($galleryImages->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\admin\gallery.blade.php ENDPATH**/ ?>