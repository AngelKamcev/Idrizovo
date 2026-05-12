

<?php $__env->startSection('title', 'Уреди Соопштење'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Уреди Соопштење</h1>
        <a href="<?php echo e(route('admin.announcements.index')); ?>" class="text-blue-600 hover:text-blue-900">← Назад</a>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.announcements.update', $announcement)); ?>" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-6">
            <label for="title_mk" class="block text-sm font-medium text-gray-700 mb-2">Наслов (Македонски)*</label>
            <input type="text" id="title_mk" name="title_mk" value="<?php echo e(old('title_mk', $announcement->getTranslation('title', 'mk'))); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="content_mk" class="block text-sm font-medium text-gray-700 mb-2">Содржина (Македонски)*</label>
            <textarea id="content_mk" name="content_mk" rows="8" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"><?php echo e(old('content_mk', $announcement->getTranslation('content', 'mk'))); ?></textarea>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Слика</label>
            
            <?php if($announcement->getImageUrl()): ?>
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Тековна слика:</p>
                    <img src="<?php echo e($announcement->getImageUrl()); ?>" alt="слика" class="h-32 w-auto object-cover rounded border border-gray-300">
                </div>
            <?php endif; ?>

            <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">Поддржани формати: JPEG, PNG, JPG, GIF (макс. 2MB). Оставете празно ако не сакате да менувате слика.</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Редослед</label>
                <input type="number" id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $announcement->sort_order)); ?>" min="0" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            </div>

            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $announcement->is_active) ? 'checked' : ''); ?> class="rounded">
                    <span class="ml-2 text-sm text-gray-700">Активно</span>
                </label>
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="auto_translate" value="1" class="rounded">
                <span class="ml-2 text-sm text-gray-700">Автоматско преведување (Англиски и Албански)</span>
            </label>
        </div>

        <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200">
            <p class="text-sm text-gray-700">
                <strong>Преводи:</strong>
            </p>
            <ul class="text-sm text-gray-600 mt-2 list-disc list-inside">
                <li>Англиски наслов: <?php echo e($announcement->getTranslation('title', 'en')); ?></li>
                <li>Албански наслов: <?php echo e($announcement->getTranslation('title', 'sq')); ?></li>
            </ul>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Зачувај Измени
            </button>
            <a href="<?php echo e(route('admin.announcements.index')); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                Откажи
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/announcements/edit.blade.php ENDPATH**/ ?>