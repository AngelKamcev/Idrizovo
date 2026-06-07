<?php $__env->startSection('title', 'Уреди слика'); ?>
<?php $__env->startSection('page-title', 'Уреди слика'); ?>
<?php $__env->startSection('page-subtitle', 'Измени постоечка слика во галеријата'); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('admin.gallery.update', $galleryImage)); ?>" method="POST" enctype="multipart/form-data" class="card max-w-3xl">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Наслов</label>
            <input type="text" name="title" value="<?php echo e(old('title', $galleryImage->adminTitle())); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Албум</label>
            <input type="text" name="album" value="<?php echo e(old('album', $galleryImage->album)); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Опис</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2"><?php echo e(old('description', $galleryImage->description)); ?></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Нова слика</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-4 py-2" accept="image/*">
            <p class="text-xs text-gray-500 mt-2">Остави празно ако не сакаш да ја менуваш сликата.</p>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-primary">Зачувај промени</button>
        <a href="<?php echo e(route('admin.gallery')); ?>" class="btn-secondary">Назад</a>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\idrizovo\Idrizovo\backend\resources\views/admin/gallery_edit.blade.php ENDPATH**/ ?>