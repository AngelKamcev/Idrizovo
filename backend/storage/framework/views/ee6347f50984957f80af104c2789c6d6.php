<?php $__env->startSection('title', 'Додај слика'); ?>
<?php $__env->startSection('page-title', 'Додај слика'); ?>
<?php $__env->startSection('page-subtitle', 'Качи нова слика во галеријата'); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('admin.gallery.store')); ?>" method="POST" enctype="multipart/form-data" class="card max-w-3xl">
    <?php echo csrf_field(); ?>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Наслов</label>
            <input type="text" name="title" value="<?php echo e(old('title')); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Албум</label>
            <input type="text" name="album" value="<?php echo e(old('album')); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Опис</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2"><?php echo e(old('description')); ?></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Слика</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-4 py-2" accept="image/*" required>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-primary">Зачувај</button>
        <a href="<?php echo e(route('admin.gallery')); ?>" class="btn-secondary">Назад</a>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/gallery_create.blade.php ENDPATH**/ ?>