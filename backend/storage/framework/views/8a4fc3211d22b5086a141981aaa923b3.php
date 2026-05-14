<?php $__env->startSection('title', 'Барања за посета'); ?>
<?php $__env->startSection('page-title', 'Барања за посета'); ?>
<?php $__env->startSection('page-subtitle', 'Барањата испратени од јавната форма за закажување'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <?php
        $stats = [
            ['label' => 'Вкупно', 'value' => $totalRequests, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'text-blue-500'],
            ['label' => 'Одобрени', 'value' => $approvedRequests, 'icon' => 'M5 13l4 4L19 7', 'color' => 'text-emerald-500'],
            ['label' => 'Откажани', 'value' => $cancelledRequests, 'icon' => 'M6 18L18 6M6 6l12 12', 'color' => 'text-red-500'],
            ['label' => 'Завршени', 'value' => $completedRequests, 'icon' => 'M9 12l2 2 4-4', 'color' => 'text-violet-500'],
        ];
    ?>

    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wide"><?php echo e($s['label']); ?></span>
                <svg class="w-4 h-4 <?php echo e($s['color']); ?>" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($s['icon']); ?>"/>
                </svg>
            </div>
            <span class="text-3xl font-medium text-gray-900 leading-none"><?php echo e($s['value']); ?></span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-900">Барања за посета</h3>
        <p class="text-xs text-gray-400 mt-0.5">Тука стигнува секое ново барање од `zakaziposeta.blade.php`.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[1260px]">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/60">
                    <th class="px-5 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Посетител</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Осудено лице</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Код</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Термин</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Порака / Придружба</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Статус</th>
                    <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Дејства</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $visitRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $chips = [
                            'approved' => ['bg-emerald-50 text-emerald-700', 'bg-emerald-400', 'Одобрено'],
                            'cancelled_by_visitor' => ['bg-amber-50 text-amber-700', 'bg-amber-400', 'Откажано од посетител'],
                            'cancelled_by_admin' => ['bg-red-50 text-red-700', 'bg-red-400', 'Откажано од админ'],
                            'completed' => ['bg-sky-50 text-sky-700', 'bg-sky-400', 'Завршено'],
                            'no_show' => ['bg-gray-100 text-gray-500', 'bg-gray-300', 'Не се појавил'],
                        ];
                        [$chipClass, $dotClass, $chipLabel] = $chips[$request->status] ?? ['bg-gray-100 text-gray-500', 'bg-gray-300', $request->status];
                    ?>
                    <tr class="hover:bg-gray-50/50 transition-colors align-top">
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($request->visitor_first_name); ?> <?php echo e($request->visitor_last_name); ?></p>
                            <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($request->visitor_email ?: '—'); ?> / <?php echo e($request->visitor_phone ?: '—'); ?></p>
                            <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($request->created_at?->format('d.m.Y H:i')); ?></p>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($request->requested_inmate_number); ?></p>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-semibold text-gray-900"><?php echo e($request->confirmation?->confirmation_code ?? '—'); ?></p>
                            <?php if($request->confirmation?->pdf_url): ?>
                                <a href="<?php echo e(asset('storage/' . ltrim($request->confirmation->pdf_url, '/'))); ?>" target="_blank" class="text-[11px] text-blue-600 hover:underline">
                                    PDF
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($request->visitSchedule?->group_name ?? '—'); ?></p>
                            <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($request->visitSchedule?->days_label ?? '—'); ?></p>
                            <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($request->visit_date?->format('d.m.Y')); ?> / <?php echo e($request->timeSlot ? $request->timeSlot->start_time . ' - ' . $request->timeSlot->end_time : '—'); ?></p>
                        </td>
                        <td class="px-4 py-4 max-w-[260px]">
                            <p class="text-xs text-gray-500 leading-relaxed"><?php echo e($request->companions->count() ? 'Придружници: ' . $request->companions->count() : 'Нема внесени придружници'); ?></p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium px-2.5 py-1 rounded-full <?php echo e($chipClass); ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?php echo e($dotClass); ?>"></span>
                                <?php echo e($chipLabel); ?>

                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <form action="<?php echo e(route('admin.visit-requests.update', $request)); ?>" method="POST" class="flex flex-col gap-2 min-w-[150px]">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <div class="relative">
                                    <select name="status" class="w-full px-3 py-2 pr-8 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-700 appearance-none focus:outline-none focus:border-gray-400 transition-colors cursor-pointer">
                                        <option value="approved" <?php if($request->status === 'approved'): echo 'selected'; endif; ?>>Одобрено</option>
                                        <option value="cancelled_by_visitor" <?php if($request->status === 'cancelled_by_visitor'): echo 'selected'; endif; ?>>Откажано од посетител</option>
                                        <option value="cancelled_by_admin" <?php if($request->status === 'cancelled_by_admin'): echo 'selected'; endif; ?>>Откажано од админ</option>
                                        <option value="completed" <?php if($request->status === 'completed'): echo 'selected'; endif; ?>>Завршено</option>
                                        <option value="no_show" <?php if($request->status === 'no_show'): echo 'selected'; endif; ?>>Не се појавил</option>
                                    </select>
                                    <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <button type="submit" class="w-full py-2 bg-gray-900 text-white text-xs font-medium rounded-lg hover:bg-gray-700 active:scale-[0.98] transition-all">
                                    Зачувај
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center text-sm text-gray-300">Нема пристигнати барања.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($visitRequests->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-100">
            <?php echo e($visitRequests->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/visit-requests.blade.php ENDPATH**/ ?>