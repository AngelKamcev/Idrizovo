<?php $__env->startSection('title', 'Управување со Соопштенија'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Управување со Соопштенија</h1>
        <a href="<?php echo e(route('admin.announcements.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Ново Соопштење
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Наслов</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Слика</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Активно</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Датум</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Редослед</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Акции</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">
                                <?php echo e($announcement->getTranslation('title', 'mk')); ?>

                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <?php echo e(Str::limit($announcement->getTranslation('content', 'mk'), 50)); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($announcement->getImageUrl()): ?>
                                <img src="<?php echo e($announcement->getImageUrl()); ?>" alt="слика" class="h-10 w-10 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400">Нема слика</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo e($announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e($announcement->is_active ? 'Активно' : 'Неактивно'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($announcement->created_at->format('d.m.Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($announcement->sort_order); ?>

                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="<?php echo e(route('admin.announcements.edit', $announcement)); ?>" class="text-blue-600 hover:text-blue-900">
                                Уреди
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.announcements.destroy', $announcement)); ?>" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Сигурни ли сте?')">
                                    Избриши
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Нема соопштенија
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <?php echo e($announcements->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\backend_modified\resources\views/admin/announcements/index.blade.php ENDPATH**/ ?>