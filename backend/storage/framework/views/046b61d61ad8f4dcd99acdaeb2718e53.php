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
            <?php echo e(__('needle_art')); ?>

          </h1>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <?php for($i = 1; $i <= 6; $i++): ?>
        <div class="bg-[#8fa8d7]/80 rounded-2xl overflow-hidden shadow-lg backdrop-blur-sm transform transition duration-300 hover:scale-105 hover:z-10">
          <img src="https://picsum.photos/500/400?<?php echo e($i); ?>" class="w-full h-72 object-cover" />
          <div class="p-5">
            <h2 class="text-white font-bold text-xl mb-3"><?php echo e(__('handmade_card_1_title')); ?></h2>
            <p class="text-white/80 text-sm leading-6 mb-5">
              <?php echo e(__('handmade_card_1_body')); ?>

            </p>
            <button class="bg-[#0E1B2F] text-white text-sm font-semibold px-5 py-2 rounded-md hover:opacity-90 transition">
              <?php echo e(__('booking')); ?>

            </button>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <div class="block md:hidden min-h-screen bg-white p-4 -mb-20">
    <div class="flex flex-col gap-4">

      <h2 class="text-4xl font-bold text-black px-2 pb-2"><?php echo e(__('gallery')); ?></h2>

      <div class="flex flex-col gap-3">

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/101/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest"><?php echo e(__('handmade_items')); ?></p>
          </div>
        </div>

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/102/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest"><?php echo e(__('activities')); ?></p>
          </div>
        </div>

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/103/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest"><?php echo e(__('events')); ?></p>
          </div>
        </div>

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/104/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest"><?php echo e(__('institution')); ?></p>
          </div>
        </div>
      </div>

      <div class="flex h-72 w-full gap-2 mt-2">
        <div class="flex-[4] hover:flex-[4] transition-all duration-500 ease-in-out bg-[url('https://picsum.photos/id/111/200/400')] bg-cover bg-center rounded-2xl cursor-pointer"></div>

        <div class="flex-1 hover:flex-[4] transition-all duration-500 ease-in-out bg-[url('https://picsum.photos/id/112/200/400')] bg-cover bg-center rounded-2xl cursor-pointer border-l border-white/10"></div>
        <div class="flex-1 hover:flex-[4] transition-all duration-500 ease-in-out bg-[url('https://picsum.photos/id/113/200/400')] bg-cover bg-center rounded-2xl cursor-pointer border-l border-white/10"></div>
        <div class="flex-1 hover:flex-[4] transition-all duration-500 ease-in-out bg-[url('https://picsum.photos/id/114/200/400')] bg-cover bg-center rounded-2xl cursor-pointer border-l border-white/10"></div>
        <div class="flex-1 hover:flex-[4] transition-all duration-500 ease-in-out bg-[url('https://picsum.photos/id/115/200/400')] bg-cover bg-center rounded-2xl cursor-pointer border-l border-white/10"></div>
      </div>

    </div>

  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\Idrizovo\Idrizovo\backend\resources\views/gallery.blade.php ENDPATH**/ ?>