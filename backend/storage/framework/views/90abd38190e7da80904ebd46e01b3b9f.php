<?php $__env->startSection('title', 'Галерија - Идризово'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white md:bg-gradient-to-b md:from-[#FFFFFF] md:via-[#6A92D4] md:to-[#FFFFFF] min-h-screen">

  <div class="hidden md:block max-w-5xl mx-auto px-6 py-8 relative">
    <div class="max-w-5xl mx-auto px-2 md:px-4 py-8 relative">
      <div class="flex items-end gap-5 mb-10 ">
        <div class="-ml-15 -mt-5">
          <button class="w-8 h-10 flex items-center justify-start text-xl text-[#0e1b38] hover:opacity-70 transition">
            <i class="fa-solid fa-chevron-left text-3xl"></i>
          </button>
        </div>
        <div class="pb-1">
            <h1 class="text-2xl md:text-3xl font-bold text-[#0e1b38]">
            <?php echo e(__('gallery')); ?>

          </h1>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <?php $__empty_1 = true; $__currentLoopData = $galleryImages->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-[#8fa8d7]/80 rounded-2xl overflow-hidden shadow-lg backdrop-blur-sm transform transition duration-300 hover:scale-105 hover:z-10">
          <img src="<?php echo e($img->resolved_url); ?>" alt="<?php echo e($img->displayTitle()); ?>" class="w-full h-72 object-cover" />
          <div class="p-5">
            <h2 class="text-white font-bold text-xl mb-3"><?php echo e($img->displayTitle() ?: __('handmade_card_1_title')); ?></h2>
            <p class="text-white/80 text-sm leading-6 mb-5">
              <?php echo e($img->description ?: __('handmade_card_1_body')); ?>

            </p>
            <?php if($img->album): ?>
              <p class="text-white/60 text-xs mb-3 uppercase tracking-wide"><?php echo e($img->album); ?></p>
            <?php endif; ?>
            <button type="button" class="bg-[#0E1B2F] text-white text-sm font-semibold px-5 py-2 rounded-md hover:opacity-90 transition">
              <?php echo e(__('reserve')); ?>

            </button>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php for($i = 1; $i <= 6; $i++): ?>
          <div class="bg-[#8fa8d7]/80 rounded-2xl overflow-hidden shadow-lg backdrop-blur-sm transform transition duration-300 hover:scale-105 hover:z-10">
            <img src="https://picsum.photos/500/400?<?php echo e($i); ?>" class="w-full h-72 object-cover" alt="" />
            <div class="p-5">
              <h2 class="text-white font-bold text-xl mb-3"><?php echo e(__('handmade_card_1_title')); ?></h2>
              <p class="text-white/80 text-sm leading-6 mb-5"><?php echo e(__('handmade_card_1_body')); ?></p>
              <button type="button" class="bg-[#0E1B2F] text-white text-sm font-semibold px-5 py-2 rounded-md hover:opacity-90 transition"><?php echo e(__('reserve')); ?></button>
            </div>
          </div>
        <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="block md:hidden min-h-screen bg-white p-4 -mb-20">
    <div class="flex flex-col gap-4">

      <h2 class="text-4xl font-bold text-black px-2 pb-2"><?php echo e(__('gallery')); ?></h2>

      <div class="flex flex-col gap-3">
        <?php
          $stripLabels = [__('handmade_items'), __('activities'), __('events'), __('institution')];
        ?>
        <?php for($i = 0; $i < 4; $i++): ?>
          <?php
            $rowImg = $galleryImages->get($i);
            $bgUrl = $rowImg && $rowImg->resolved_url ? $rowImg->resolved_url : 'https://picsum.photos/id/'.(101 + $i).'/400/200';
            $stripTitle = ($rowImg && $rowImg->album) ? $rowImg->album : ($stripLabels[$i] ?? '');
          ?>
          <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm"
               style="background-image: url('<?php echo e(e($bgUrl)); ?>')">
            <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
              <p class="text-center text-white font-bold text-xs uppercase tracking-widest"><?php echo e($stripTitle); ?></p>
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <div class="flex h-72 w-full gap-2 mt-2">
        <?php $__currentLoopData = [111, 112, 113, 114, 115]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fi => $pid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $fanImg = $galleryImages->get($fi);
            $fanUrl = $fanImg && $fanImg->resolved_url ? $fanImg->resolved_url : 'https://picsum.photos/id/'.$pid.'/200/400';
            $flexClass = $fi === 0 ? 'flex-[4] hover:flex-[4]' : 'flex-1 hover:flex-[4]';
            $borderClass = $fi > 0 ? ' border-l border-white/10' : '';
          ?>
          <div class="<?php echo e($flexClass); ?> transition-all duration-500 ease-in-out bg-cover bg-center rounded-2xl cursor-pointer<?php echo e($borderClass); ?>"
               style="background-image: url('<?php echo e(e($fanUrl)); ?>')"></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

    </div>

  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\gallery.blade.php ENDPATH**/ ?>