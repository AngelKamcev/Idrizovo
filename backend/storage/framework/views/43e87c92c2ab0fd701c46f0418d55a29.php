<?php $__env->startSection('title', 'Дневник на активности'); ?>
<?php $__env->startSection('page-title', 'Дневник на активности'); ?>
<?php $__env->startSection('page-subtitle', 'Преглед на посети и промени на сајтот'); ?>

<?php $__env->startSection('content'); ?>

<form method="GET" action="<?php echo e(route('admin.site-logs')); ?>" class="mb-6 flex flex-col sm:flex-row gap-3 flex-wrap">
    <input type="hidden" name="tab" value="<?php echo e($tab); ?>">
    <div class="w-full sm:w-auto">
        <label for="month" class="sr-only">Месец</label>
        <select
            id="month"
            name="month"
            class="w-full sm:w-48 rounded-xl border border-gray-200 px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#2f5fa8]/30"
            onchange="this.form.submit()"
        >
            <option value="all" <?php if(($month ?? '') === 'all'): echo 'selected'; endif; ?>>Сите месеци</option>
            <?php $__currentLoopData = $availableMonths ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(($month ?? '') === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="flex-1 min-w-[200px]">
        <input
            type="search"
            name="q"
            value="<?php echo e($search); ?>"
            placeholder="Пребарај по IP, име, соопштение…"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2f5fa8]/30 focus:border-[#2f5fa8]"
        >
    </div>
    <button type="submit" class="rounded-xl bg-[#2f5fa8] hover:bg-[#244f91] text-white px-5 py-2.5 text-sm font-semibold transition-colors">
        Пребарај
    </button>
    <?php if($search !== ''): ?>
        <a href="<?php echo e(route('admin.site-logs', ['tab' => $tab])); ?>" class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 text-center">
            Исчисти
        </a>
    <?php endif; ?>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white border border-gray-100 rounded-2xl p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Посети на сајтот</p>
        <p class="text-3xl font-medium text-gray-900 mt-2"><?php echo e(number_format($siteTotal)); ?></p>
    </div>
    <div class="bg-white border border-gray-100 rounded-2xl p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Промени од персонал</p>
        <p class="text-3xl font-medium text-gray-900 mt-2"><?php echo e(number_format($staffTotal)); ?></p>
    </div>
</div>

<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2">
        <a href="<?php echo e(route('admin.site-logs', array_merge(request()->except('tab'), ['tab' => 'site']))); ?>"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors <?php echo e($tab === 'site' ? 'bg-[#2f5fa8] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">
            Посети на сајтот
        </a>
        <a href="<?php echo e(route('admin.site-logs', array_merge(request()->except('tab'), ['tab' => 'staff']))); ?>"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors <?php echo e($tab === 'staff' ? 'bg-[#2f5fa8] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">
            Промени од админ / воспитувач
        </a>
    </div>

    <?php if($tab === 'site'): ?>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px]">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/60">
                        <th class="px-5 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Време</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Што се случило</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Посетител</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $siteLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors align-top">
                            <td class="px-5 py-4 text-sm text-gray-700 whitespace-nowrap"><?php echo e($log->at ?? '—'); ?></td>
                            <td class="px-4 py-4 text-sm text-gray-900"><?php echo e($log->description ?? '—'); ?></td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <?php echo e($log->visitor ?? 'Гостин'); ?>

                                <?php if(!empty($log->locale)): ?>
                                    <span class="text-[11px] text-gray-400 block">јазик: <?php echo e(strtoupper($log->locale)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-4 text-sm font-mono text-gray-700"><?php echo e($log->ip ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-sm text-gray-400">Нема записи за посети.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($siteLogs->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100"><?php echo e($siteLogs->withQueryString()->links()); ?></div>
        <?php endif; ?>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/60">
                        <th class="px-5 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Време</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Кој</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Улога</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Што направил</th>
                        <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $staffLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors align-top">
                            <td class="px-5 py-4 text-sm text-gray-700 whitespace-nowrap"><?php echo e($log->at ?? '—'); ?></td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-900"><?php echo e($log->user_name ?? '—'); ?></td>
                            <td class="px-4 py-4 text-sm text-gray-600"><?php echo e($log->role_label ?? '—'); ?></td>
                            <td class="px-4 py-4 text-sm text-gray-900"><?php echo e($log->description ?? '—'); ?></td>
                            <td class="px-4 py-4 text-sm font-mono text-gray-700"><?php echo e($log->ip ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-gray-400">Нема записи за промени од персонал.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($staffLogs->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100"><?php echo e($staffLogs->withQueryString()->links()); ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/site-logs.blade.php ENDPATH**/ ?>