<?php $__env->startSection('title', 'Галерија'); ?>
<?php $__env->startSection('page-title', 'Галерија'); ?>
<?php $__env->startSection('page-subtitle', 'Управување со сликите по категорија'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
<div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-3">
    <i class="fas fa-check-circle text-green-500"></i> <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<div class="card mb-6">
    <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <i class="fas fa-upload text-blue-500"></i> Прикачи нови слики
    </h3>
    <form action="<?php echo e(route('admin.gallery.store')); ?>" method="POST" enctype="multipart/form-data"
          class="flex flex-wrap items-end gap-4">
        <?php echo csrf_field(); ?>

        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Категорија <span class="text-red-500">*</span></label>
            <select name="handcraft_category" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                <option value="">-- Изберете --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($slug); ?>" <?php echo e($categorySlug === $slug ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Опис (опционално)</label>
            <input type="text" name="description_mk" placeholder="Краток опис на сликите..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm" />
        </div>

        <div class="flex-[2] min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Слики <span class="text-red-500">*</span></label>
            <input type="file" name="images[]" multiple accept="image/*" required
                   class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            <p class="text-xs text-gray-400 mt-1">Можете да изберете повеќе слики одеднаш. Максимум 8MB по слика.</p>
        </div>

        <div>
            <button type="submit" class="btn-primary whitespace-nowrap">
                <i class="fas fa-upload mr-2"></i> Прикачи
            </button>
        </div>
    </form>
    <?php if($errors->any()): ?>
    <div class="mt-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
</div>


<div class="flex flex-wrap gap-2 mb-6">
    <a href="<?php echo e(route('admin.gallery')); ?>"
       class="px-4 py-1.5 rounded-full text-sm font-medium border transition
              <?php echo e(!$categorySlug ? 'bg-[#0E1B2F] text-white border-[#0E1B2F]' : 'border-gray-300 text-gray-600 hover:border-gray-500'); ?>">
        Сите (<?php echo e($total); ?>)
    </a>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $count = \Illuminate\Support\Facades\DB::table('gallery')->where('handcraft_category', $slug)->count(); ?>
        <a href="<?php echo e(route('admin.gallery', ['category' => $slug])); ?>"
           class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                  <?php echo e($categorySlug === $slug ? 'bg-[#0E1B2F] text-white border-[#0E1B2F]' : 'border-gray-300 text-gray-600 hover:border-gray-500'); ?>">
            <?php echo e($label); ?> (<?php echo e($count); ?>)
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<?php if($images->count()): ?>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $src = \Illuminate\Support\Str::startsWith($image->image_url, ['http','//'])
                ? $image->image_url : asset($image->image_url);
        ?>
        <div class="group relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all bg-gray-100">
            <img src="<?php echo e($src); ?>" alt="<?php echo e($image->description_mk ?? ''); ?>"
                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />

            
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2">
                <a href="<?php echo e($src); ?>" target="_blank"
                   class="bg-white text-blue-600 hover:bg-gray-100 p-2 rounded-full transition">
                    <i class="fas fa-eye"></i>
                </a>
                <form action="<?php echo e(route('admin.gallery.destroy', $image->id)); ?>" method="POST"
                      onsubmit="return confirm('Сигурно сакате да ја избришете оваа слика?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="bg-white text-red-600 hover:bg-gray-100 p-2 rounded-full transition">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>

            
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100 transition-all">
                <p class="font-semibold truncate"><?php echo e($image->category_name); ?></p>
                <?php if($image->description_mk): ?>
                    <p class="opacity-80 truncate"><?php echo e($image->description_mk); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="mt-6 flex items-center justify-between">
    <p class="text-sm text-gray-500">
        Приказ <?php echo e($images->firstItem()); ?>–<?php echo e($images->lastItem()); ?> од <?php echo e($images->total()); ?> слики
    </p>
    <div><?php echo e($images->appends(['category' => $categorySlug])->links()); ?></div>
</div>

<?php else: ?>
<div class="text-center py-24 text-gray-400">
    <i class="fas fa-images text-6xl mb-4 block"></i>
    <p class="text-lg font-medium">Нема слики во оваа категорија.</p>
    <p class="text-sm mt-1">Прикачете слики преку формата погоре.</p>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\backend_modified\resources\views/admin/gallery.blade.php ENDPATH**/ ?>