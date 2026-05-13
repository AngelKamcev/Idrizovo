<?php $__env->startSection('title', 'Рачни Изработки'); ?>
<?php $__env->startSection('page-title', 'Рачни Изработки'); ?>
<?php $__env->startSection('page-subtitle', 'Управување со 4-те категории на изработки'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
<div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-3">
    <i class="fas fa-check-circle text-green-500"></i>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<div class="mb-6">
    <p class="text-gray-500 text-sm">
        Секоја категорија претставува еден дел на страницата „Рачни Изработки". Уредете ги наслов, опис и слика. 
        <strong>„Види повеќе"</strong> на јавната страна води до галеријата филтрирана по таа категорија.
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $hc = $handcrafts[$slug] ?? null; ?>

        <div class="card hover:shadow-lg transition-all flex flex-col gap-4">

            
            <div class="relative rounded-xl overflow-hidden bg-gray-100 h-48">
                <?php if($hc && $hc->image_url): ?>
                    <img src="<?php echo e(\Illuminate\Support\Str::startsWith($hc->image_url, ['http','//']) ? $hc->image_url : asset($hc->image_url)); ?>"
                         class="w-full h-full object-cover" alt="<?php echo e($hc->title_mk); ?>" />
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                <?php endif; ?>

                
                <div class="absolute top-2 right-2">
                    <?php if($hc && $hc->is_published): ?>
                        <span class="bg-green-600 text-white px-2 py-1 rounded-full text-xs font-semibold">Активна</span>
                    <?php else: ?>
                        <span class="bg-gray-400 text-white px-2 py-1 rounded-full text-xs font-semibold">Скриена</span>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="flex-1 flex flex-col">
                <h3 class="font-bold text-gray-800 text-lg mb-1">
                    <?php echo e($hc ? $hc->title_mk : $label); ?>

                </h3>
                <p class="text-sm text-gray-400 mb-2 font-mono"><?php echo e($slug); ?></p>
                <?php if($hc && $hc->description_mk): ?>
                    <p class="text-sm text-gray-600 line-clamp-3 flex-1"><?php echo e(Str::limit($hc->description_mk, 150)); ?></p>
                <?php else: ?>
                    <p class="text-sm text-gray-400 italic">Нема опис.</p>
                <?php endif; ?>
            </div>

            
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <a href="<?php echo e(route('gallery')); ?>?category=<?php echo e($slug); ?>" target="_blank"
                   class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Прегледај галерија
                </a>
                <?php if($hc): ?>
                    <a href="<?php echo e(route('admin.izrabotki.edit', $slug)); ?>" class="btn-edit text-xs">
                        <i class="fas fa-edit mr-1"></i> Уреди
                    </a>
                <?php else: ?>
                    <span class="text-xs text-red-400 italic">Запишот не постои – извршете ги миграциите.</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\backend_modified\resources\views/admin/izrabotki.blade.php ENDPATH**/ ?>