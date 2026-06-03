<?php $__env->startSection('title', 'Преглед - Жалби и Пофалби'); ?>
<?php $__env->startSection('page-title', 'Преглед'); ?>
<?php $__env->startSection('page-subtitle', 'Жалби и пофалби од јавниот формулар'); ?>

<?php $__env->startSection('content'); ?>

<!-- STATS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Вкупно жалби -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Жалби - Вкупно</span>
            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="text-3xl font-medium text-gray-900 leading-none"><?php echo e($totalComplaints); ?></span>
    </div>

    <!-- Нови жалби -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Жалби - Нови</span>
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <span class="text-3xl font-medium text-gray-900 leading-none"><?php echo e($newComplaints); ?></span>
    </div>

    <!-- Вкупно пофалби -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Пофалби - Вкупно</span>
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.23a2 2 0 01-1.788 1.106H2.909a2 2 0 01-2-2V9a2 2 0 012-2h15.79a2 2 0 012 2v2.5"/>
            </svg>
        </div>
        <span class="text-3xl font-medium text-gray-900 leading-none"><?php echo e($totalCompliments); ?></span>
    </div>

    <!-- Нови пофалби -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Пофалби - Нови</span>
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <span class="text-3xl font-medium text-gray-900 leading-none"><?php echo e($newCompliments); ?></span>
    </div>
</div>

<!-- RECENT COMPLAINTS -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Скорешни Жалби</h2>
            <p class="text-xs text-gray-400 mt-0.5">Последните пристигнати жалби</p>
        </div>
        <a href="<?php echo e(route('admin.complaints')); ?>" class="text-xs font-medium text-blue-600 hover:text-blue-700">Види сите →</a>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
        <?php if($complaints->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/60">
                            <th class="px-5 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Испраќач</th>
                            <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Наслов</th>
                            <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Статус</th>
                            <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $chips = [
                                    'new'         => ['bg-amber-50 text-amber-700', 'bg-amber-400', 'Ново'],
                                    'seen'        => ['bg-sky-50 text-sky-700', 'bg-sky-400', 'Прегледано'],
                                    'in_progress' => ['bg-violet-50 text-violet-700', 'bg-violet-400', 'Во работа'],
                                    'closed'      => ['bg-emerald-50 text-emerald-700', 'bg-emerald-400', 'Затворено'],
                                ];
                                [$chipClass, $dotClass, $chipLabel] = $chips[$complaint->status] ?? ['bg-gray-100 text-gray-500', 'bg-gray-300', $complaint->status];
                            ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-4">
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($complaint->submitted_by_name); ?></p>
                                    <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($complaint->created_at?->format('d.m.Y')); ?></p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-700"><?php echo e(\Illuminate\Support\Str::limit($complaint->subject, 50)); ?></p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium px-2.5 py-1 rounded-full <?php echo e($chipClass); ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?php echo e($dotClass); ?>"></span>
                                        <?php echo e($chipLabel); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <form action="<?php echo e(route('admin.complaints.update', $complaint)); ?>" method="POST" class="contents">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <?php if($complaint->status === 'new'): ?>
                                            <input type="hidden" name="status" value="seen">
                                            <button type="submit" class="text-xs text-sky-600 hover:text-sky-700 font-medium">Прочитај</button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="px-5 py-12 text-center text-sm text-gray-300">
                Нема пристигнати жалби.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- RECENT COMPLIMENTS -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Скорешни Пофалби</h2>
            <p class="text-xs text-gray-400 mt-0.5">Последните пристигнати позитивни пораки</p>
        </div>
        <a href="<?php echo e(route('admin.compliments')); ?>" class="text-xs font-medium text-green-600 hover:text-green-700">Види сите →</a>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
        <?php if($compliments->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/60">
                            <th class="px-5 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Испраќач</th>
                            <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Наслов</th>
                            <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest">Статус</th>
                            <th class="px-4 py-3 text-left text-[10px] font-medium text-gray-400 uppercase tracking-widest"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php $__currentLoopData = $compliments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compliment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $chips = [
                                    'new'         => ['bg-amber-50 text-amber-700', 'bg-amber-400', 'Ново'],
                                    'seen'        => ['bg-sky-50 text-sky-700', 'bg-sky-400', 'Прегледано'],
                                    'in_progress' => ['bg-violet-50 text-violet-700', 'bg-violet-400', 'Во работа'],
                                    'closed'      => ['bg-emerald-50 text-emerald-700', 'bg-emerald-400', 'Затворено'],
                                ];
                                [$chipClass, $dotClass, $chipLabel] = $chips[$compliment->status] ?? ['bg-gray-100 text-gray-500', 'bg-gray-300', $compliment->status];
                            ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-4">
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($compliment->submitted_by_name); ?></p>
                                    <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($compliment->created_at?->format('d.m.Y')); ?></p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-700"><?php echo e(\Illuminate\Support\Str::limit($compliment->subject, 50)); ?></p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium px-2.5 py-1 rounded-full <?php echo e($chipClass); ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?php echo e($dotClass); ?>"></span>
                                        <?php echo e($chipLabel); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <form action="<?php echo e(route('admin.compliments.update', $compliment)); ?>" method="POST" class="contents">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <?php if($compliment->status === 'new'): ?>
                                            <input type="hidden" name="status" value="seen">
                                            <button type="submit" class="text-xs text-sky-600 hover:text-sky-700 font-medium">Прочитај</button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="px-5 py-12 text-center text-sm text-gray-300">
                Нема пристигнати пофалби.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\admin\reviewer-dashboard.blade.php ENDPATH**/ ?>