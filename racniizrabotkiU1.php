<?php require_once __DIR__ . '/header.php'; ?>

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
            Уметност со игла и конец
          </h1>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <div class="bg-[#8fa8d7]/80 rounded-2xl overflow-hidden shadow-lg backdrop-blur-sm transform transition duration-300 hover:scale-105 hover:z-10">
          <img src="https://picsum.photos/500/400?<?= $i ?>" class="w-full h-72 object-cover" />
          <div class="p-5">
            <h2 class="text-white font-bold text-xl mb-3">Lorem Ipsum</h2>
            <p class="text-white/80 text-sm leading-6 mb-5">
              Lorem Ipsum is simply dummy text of the printing and
              typesetting industry. Lorem Ipsum has been the industry's
              standard dummy text ever since the
            </p>
            <button class="bg-[#0E1B2F] text-white text-sm font-semibold px-5 py-2 rounded-md hover:opacity-90 transition">
              Резервирај
            </button>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <div class="block md:hidden min-h-screen bg-white p-4 -mb-20">
    <div class="flex flex-col gap-4">

      <h2 class="text-4xl font-bold text-black px-2 pb-2">Галерија</h2>

      <div class="flex flex-col gap-3">

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/101/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest">Рачни Изработки</p>
          </div>
        </div>

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/102/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest">Активности</p>
          </div>
        </div>

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/103/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest">Настани</p>
          </div>
        </div>

        <div class="group relative h-32 w-full overflow-hidden rounded-2xl bg-[url('https://picsum.photos/id/104/400/200')] bg-cover bg-center transition-all duration-300 active:scale-95 hover:-translate-y-2 hover:scale-[1.02] cursor-pointer shadow-sm">
          <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-md py-3">
            <p class="text-center text-white font-bold text-xs uppercase tracking-widest">Установа</p>
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

  <?php require_once __DIR__ . '/footer.php'; ?>