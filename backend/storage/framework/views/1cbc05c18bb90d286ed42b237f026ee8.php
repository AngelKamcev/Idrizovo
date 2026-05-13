<?php $__env->startSection('title', 'Галерија - Идризово'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white md:bg-gradient-to-b md:from-[#FFFFFF] md:via-[#6A92D4] md:to-[#FFFFFF] min-h-screen">

  
  <div class="hidden md:block max-w-5xl mx-auto px-6 py-8 relative">
    <div class="max-w-5xl mx-auto px-2 md:px-4 py-8 relative">

      
      <div class="flex items-end gap-5 mb-10">
        <div class="-ml-15 -mt-5">
          <a href="<?php echo e($categorySlug ? route('izrabotki') : route('index')); ?>"
             class="w-8 h-10 flex items-center justify-start text-xl text-[#0e1b38] hover:opacity-70 transition">
            <i class="fa-solid fa-chevron-left text-3xl"></i>
          </a>
        </div>
        <div class="pb-1">
          <h1 class="text-2xl md:text-3xl font-bold text-[#0e1b38]">
            <?php if($categorySlug && $activeCategory): ?>
              <?php echo e($activeCategory->title_mk); ?>

            <?php else: ?>
              <?php echo e(__('gallery')); ?>

            <?php endif; ?>
          </h1>
          <?php if($categorySlug): ?>
            <p class="text-sm text-gray-500 mt-1">
              Рачни Изработки › <?php echo e($categories[$categorySlug] ?? $categorySlug); ?>

            </p>
          <?php endif; ?>
        </div>
      </div>

      
      <div class="flex flex-wrap gap-2 mb-8">
        <a href="<?php echo e(route('gallery')); ?>"
           class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                  <?php echo e(!$categorySlug ? 'bg-[#0E1B2F] text-white border-[#0E1B2F]' : 'border-gray-300 text-gray-600 hover:border-[#0E1B2F]'); ?>">
          Сите
        </a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('gallery')); ?>?category=<?php echo e($slug); ?>"
             class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                    <?php echo e($categorySlug === $slug ? 'bg-[#0E1B2F] text-white border-[#0E1B2F]' : 'border-gray-300 text-gray-600 hover:border-[#0E1B2F]'); ?>">
            <?php echo e($label); ?>

          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    
    <?php if($images->count()): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $src = \Illuminate\Support\Str::startsWith($image->image_url, ['http','//'])
                ? $image->image_url : asset($image->image_url);
            $desc = app()->getLocale() === 'en'
                ? ($image->description_en ?? $image->description_mk)
                : (app()->getLocale() === 'al'
                    ? ($image->description_al ?? $image->description_mk)
                    : $image->description_mk);
          ?>
          <div class="bg-[#8fa8d7]/80 rounded-2xl overflow-hidden shadow-lg backdrop-blur-sm transform transition duration-300 hover:scale-105 hover:z-10">
            <img src="<?php echo e($src); ?>" class="w-full h-72 object-cover" alt="<?php echo e($desc); ?>" />
            <?php if($desc): ?>
            <div class="p-5">
              <p class="text-white/90 text-sm leading-6"><?php echo e($desc); ?></p>
            </div>
            <?php endif; ?>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <?php if($images->hasPages()): ?>
        <div class="mt-10"><?php echo e($images->appends(['category' => $categorySlug])->links()); ?></div>
      <?php endif; ?>

    <?php else: ?>
      <div class="text-center py-24 text-gray-400">
        <i class="fas fa-images text-5xl mb-4 block"></i>
        <p class="text-lg">Нема слики во оваа категорија.</p>
        <?php if($categorySlug): ?>
          <a href="<?php echo e(route('gallery')); ?>" class="mt-4 inline-block text-[#0E1B2F] underline text-sm">
            ← Назад кон сите слики
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  
  <div class="block md:hidden min-h-screen bg-white p-4 -mb-20">
    <div class="flex flex-col gap-4">

      <?php if($categorySlug): ?>
        <a href="<?php echo e(route('gallery')); ?>" class="flex items-center gap-2 text-[#0e1b38] font-medium text-sm">
          <i class="fa-solid fa-chevron-left"></i> Назад
        </a>
      <?php endif; ?>

      <h2 class="text-4xl font-bold text-black px-2 pb-2">
        <?php if($categorySlug && $activeCategory): ?>
          <?php echo e($activeCategory->title_mk); ?>

        <?php else: ?>
          <?php echo e(__('gallery')); ?>

        <?php endif; ?>
      </h2>

      <?php if(!$categorySlug): ?>
        
        <div class="flex flex-col gap-3">
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $i = $loop->index; ?>
            <a href="<?php echo e(route('gallery')); ?>?category=<?php echo e($slug); ?>"
               class="group relative h-32 w-full overflow-hidden rounded-2xl bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm"
               style="background-image: url('https://picsum.photos/id/<?php echo e(100 + $i); ?>/400/200')">
              <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
                <p class="text-center text-white font-bold text-xs uppercase tracking-widest"><?php echo e($label); ?></p>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

      <?php else: ?>
        
        <div class="flex flex-col gap-4">
          <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              $src = \Illuminate\Support\Str::startsWith($image->image_url, ['http','//'])
                  ? $image->image_url : asset($image->image_url);
              $desc = app()->getLocale() === 'en'
                  ? ($image->description_en ?? $image->description_mk)
                  : (app()->getLocale() === 'al'
                      ? ($image->description_al ?? $image->description_mk)
                      : $image->description_mk);
            ?>
            <div class="rounded-2xl overflow-hidden shadow-md">
              <img src="<?php echo e($src); ?>" class="w-full h-64 object-cover" />
              <?php if($desc): ?>
              <div class="p-3 bg-white">
                <p class="text-sm text-gray-600"><?php echo e($desc); ?></p>
              </div>
              <?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-16 text-gray-400">
              <p>Нема слики во оваа категорија.</p>
              <a href="<?php echo e(route('gallery')); ?>" class="mt-2 inline-block text-[#0E1B2F] underline text-sm">← Назад</a>
            </div>
          <?php endif; ?>
        </div>

        <?php if($images->hasPages()): ?>
          <div class="mt-6"><?php echo e($images->appends(['category' => $categorySlug])->links()); ?></div>
        <?php endif; ?>
      <?php endif; ?>

      
      <?php if(!$categorySlug): ?>
      <div class="flex h-72 w-full gap-2 mt-2">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $i = $loop->index; ?>
          <a href="<?php echo e(route('gallery')); ?>?category=<?php echo e($slug); ?>"
             class="<?php echo e($i === 0 ? 'flex-[4]' : 'flex-1'); ?> hover:flex-[4] transition-all duration-500 ease-in-out bg-cover bg-center rounded-2xl cursor-pointer <?php echo e($i > 0 ? 'border-l border-white/10' : ''); ?>"
             style="background-image: url('https://picsum.photos/id/<?php echo e(110 + $i); ?>/200/400')"></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <?php endif; ?>

    </div>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\backend_modified\resources\views/gallery.blade.php ENDPATH**/ ?>