<?php $__env->startSection('title', 'Уреди изработка'); ?>
<?php $__env->startSection('page-title', 'Уреди изработка'); ?>
<?php $__env->startSection('page-subtitle', 'Измени наслов/опис и управувај со 4+ слики за секцијата'); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.izrabotki.update', $handcraft)); ?>" enctype="multipart/form-data" class="card max-w-3xl">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>

    <?php if($errors->any()): ?>
        <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Наслов</label>
            <input type="text" name="title_mk" value="<?php echo e(old('title_mk', $handcraft->title_mk)); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Опис</label>
            <textarea name="description_mk" rows="6" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required><?php echo e(old('description_mk', $handcraft->description_mk)); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Нова главна слика (опционално)</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Додај дополнителни слики</label>
            <input type="file" name="images[]" accept="image/*" multiple class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            <p class="mt-1 text-xs text-gray-500">Мора да останат најмалку 4 слики вкупно (1 главна + 3 дополнителни).</p>
        </div>

        <div class="rounded-lg border border-gray-200 p-3 bg-gray-50">
            <p class="text-sm text-gray-600 mb-2">Тековна слика</p>
            <img src="<?php echo e($handcraft->resolved_image_url); ?>" alt="<?php echo e($handcraft->title_mk); ?>" class="h-48 rounded-lg object-cover">
        </div>

        <?php if($handcraft->images->isNotEmpty()): ?>
            <div class="rounded-lg border border-gray-200 p-3 bg-gray-50">
                <p class="text-sm text-gray-700 mb-3">Дополнителни слики (штиклирај за бришење)</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php $__currentLoopData = $handcraft->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="block rounded-lg border border-gray-200 p-2 bg-white cursor-pointer">
                            <img src="<?php echo e($image->resolved_image_url); ?>" class="h-28 w-full object-cover rounded mb-2" alt="Дополнителна слика">
                            <span class="inline-flex items-center gap-2 text-xs text-gray-700">
                                <input type="checkbox" name="remove_image_ids[]" value="<?php echo e($image->id); ?>" class="rounded">
                                Избриши
                            </span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" class="rounded" <?php echo e(old('is_published', $handcraft->is_published) ? 'checked' : ''); ?>>
            <span class="text-sm text-gray-700">Објавено</span>
        </label>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-primary">Зачувај промени</button>
        <a href="<?php echo e(route('admin.izrabotki')); ?>" class="btn-secondary">Назад</a>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\admin\izrabotki_edit.blade.php ENDPATH**/ ?>