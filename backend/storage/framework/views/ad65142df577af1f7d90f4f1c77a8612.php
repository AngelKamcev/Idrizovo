<?php $__env->startSection('title', 'Распоред на посети'); ?>
<?php $__env->startSection('page-title', 'Распоред на посети'); ?>
<?php $__env->startSection('page-subtitle', 'Управување со групите и термините за посета преку портирница'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="grid grid-cols-1 xl:grid-cols-[300px_1fr] gap-6 items-start">

    
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
        <div class="px-6 pt-5 pb-0">
            <h3 class="text-sm font-semibold text-gray-900">Нова група</h3>
            <p class="text-xs text-gray-400 mt-0.5">Пополни ги полињата подолу</p>
        </div>
        <div class="h-px bg-gray-100 mt-4"></div>

        <form method="POST" action="<?php echo e(route('admin.visit-schedules.store')); ?>" class="p-6 flex flex-col gap-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1.5">Ime на група</label>
                <input type="text" name="group_name" value="<?php echo e(old('group_name')); ?>"
                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900
                           focus:outline-none focus:border-gray-400 focus:ring-2 focus:ring-black/5 transition-all"
                    placeholder="пр. 1 Група" required>
            </div>

            <div>
                <label class="block text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1.5">Денови</label>
                <input type="text" name="days_label" value="<?php echo e(old('days_label')); ?>"
                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900
                           focus:outline-none focus:border-gray-400 focus:ring-2 focus:ring-black/5 transition-all"
                    placeholder="пр. Понеделник – Четврток" required>
            </div>

            <div>
                <label class="block text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1.5">Време</label>
                <input type="text" name="time_range" value="<?php echo e(old('time_range')); ?>"
                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900
                           focus:outline-none focus:border-gray-400 focus:ring-2 focus:ring-black/5 transition-all"
                    placeholder="пр. 08:30 – 09:30" required>
            </div>

            <div>
                <label class="block text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-1.5">Редослед</label>
                <input type="number" name="sort_order" value="<?php echo e(old('sort_order', 0)); ?>"
                    class="w-24 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900
                           focus:outline-none focus:border-gray-400 focus:ring-2 focus:ring-black/5 transition-all"
                    min="0">
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded accent-gray-900" checked>
                <span class="text-sm text-gray-600">Активна група</span>
            </label>

            <button type="submit"
                class="w-full py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg
                       hover:bg-gray-700 active:scale-[0.99] transition-all">
                Зачувај групa
            </button>
        </form>
    </div>

    
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
        <div class="flex items-start justify-between px-6 pt-5 pb-0">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Постоечки групи</h3>
                <p class="text-xs text-gray-400 mt-0.5">Прикажани на контакт страната</p>
            </div>
            <span class="text-xs text-gray-400 bg-gray-50 border border-gray-100 px-3 py-1 rounded-full">
                <?php echo e($visitSchedules->count()); ?> групи
            </span>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[580px]">
                <thead>
                    <tr class="border-y border-gray-100 bg-gray-50/50">
                        <th class="px-5 py-2.5 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Група</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Денови</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Време</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Статус</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Дејства</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $visitSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-sm font-medium text-gray-900"><?php echo e($vs->group_name); ?></p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Редослед #<?php echo e($vs->sort_order); ?></p>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-gray-600"><?php echo e($vs->days_label); ?></td>
                            <td class="px-4 py-3.5">
                                <span class="font-mono text-xs text-gray-600 bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-md">
                                    <?php echo e($vs->time_range); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <?php if($vs->is_active): ?>
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>Активна
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium bg-gray-100 text-gray-400 px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 inline-block"></span>Неактивна
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    
                                    <div x-data="{ open: false }">
                                        <button @click="open = true"
                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Уреди
                                        </button>

                                        <div x-show="open" x-cloak @keydown.escape.window="open = false"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 p-4">
                                            <div @click.outside="open = false"
                                                class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-semibold text-gray-900">Уреди: <?php echo e($vs->group_name); ?></h4>
                                                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </div>
                                                <form method="POST" action="<?php echo e(route('admin.visit-schedules.update', $vs)); ?>" class="space-y-3">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                    <input type="text" name="group_name" value="<?php echo e($vs->group_name); ?>"
                                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-gray-400" required>
                                                    <input type="text" name="days_label" value="<?php echo e($vs->days_label); ?>"
                                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-gray-400" required>
                                                    <input type="text" name="time_range" value="<?php echo e($vs->time_range); ?>"
                                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-gray-400" required>
                                                    <input type="number" name="sort_order" value="<?php echo e($vs->sort_order); ?>"
                                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-gray-400" min="0">
                                                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                                        <input type="checkbox" name="is_active" value="1" class="accent-gray-900" <?php if($vs->is_active): echo 'checked'; endif; ?>>
                                                        Активна
                                                    </label>
                                                    <button type="submit"
                                                        class="w-full py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                                        Зачувај промени
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <form method="POST" action="<?php echo e(route('admin.visit-schedules.destroy', $vs)); ?>"
                                        onsubmit="return confirm('Дали си сигурен?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="inline-flex items-center text-xs font-medium text-red-500 bg-white border border-red-100 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-gray-300">
                                Нема внесени групи.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Angel\Desktop\Idrizovo-dimeBackend\backend\resources\views/admin/visit-schedules.blade.php ENDPATH**/ ?>