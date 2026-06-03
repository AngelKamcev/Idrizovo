<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Преглед на системот и брз пристап до содржината'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $user = auth()->user();
    $isAdmin = $user?->isAdmin();
    $isReviewer = $user?->isReviewer();
?>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Активности</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($activitiesCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-list text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Главни активности на почетната</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Соопштенија</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($announcementsCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-newspaper text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Објавени записи во системот</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Галерија</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($galleryCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-images text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Активни слики во галеријата</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Рачни изработки</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($handcraftsCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-hammer text-orange-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Објавени изработки</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Барања за посета</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($visitRequestsCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-check text-sky-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Вкупно поднесени барања</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Одобрени барања</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($approvedRequestsCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Посети со статус approved</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Жалби</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($complaintsCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-comments text-red-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Непроцесирани и процесирани</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Пофалби</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($complimentsCount ?? 0); ?></h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-thumbs-up text-amber-600 text-xl"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Сите пристигнати пофалби</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-1">
        <div class="card h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Брзи дејства</h3>
            <div class="space-y-3">
                <a href="<?php echo e(route('admin.main-activities.create')); ?>" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Нова активност
                </a>
                <a href="<?php echo e(route('admin.announcements.create')); ?>" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-file-circle-plus mr-2"></i> Ново соопштение
                </a>
                <a href="<?php echo e(route('admin.gallery.create')); ?>" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-image mr-2"></i> Нова слика
                </a>
                <a href="<?php echo e(route('admin.izrabotki')); ?>" class="w-full btn-primary text-left inline-flex items-center">
                    <i class="fas fa-hammer mr-2"></i> Уреди изработки
                </a>
                <a href="<?php echo e(route('admin.aboutus')); ?>" class="w-full btn-secondary text-left inline-flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Уреди „За Нас“
                </a>
                <a href="<?php echo e(route('admin.visit-schedules')); ?>" class="w-full btn-secondary text-left inline-flex items-center">
                    <i class="fas fa-clock mr-2"></i> Распоред на посети
                </a>
                <?php if($isAdmin): ?>
                    <a href="<?php echo e(route('admin.visit-requests')); ?>" class="w-full btn-secondary text-left inline-flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i> Барања за посета
                    </a>
                    <a href="<?php echo e(route('admin.reviewer-dashboard')); ?>" class="w-full btn-secondary text-left inline-flex items-center">
                        <i class="fas fa-comments mr-2"></i> Жалби и пофалби
                    </a>
                <?php endif; ?>
                <?php if($isReviewer): ?>
                    <a href="<?php echo e(route('admin.reviewer-dashboard')); ?>" class="w-full btn-secondary text-left inline-flex items-center">
                        <i class="fas fa-comments mr-2"></i> Жалби и пофалби
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="card h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Статус на системот</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Веб сервер</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Активен</span>
                </div>
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">База на податоци</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Поврзана</span>
                </div>
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Галерија и содржини</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Синхронизирани</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700">Рачни изработки</span>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">Активни</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни активности</h3>
            <a href="<?php echo e(route('admin.main-activities.index')); ?>" class="text-blue-600 text-sm hover:underline">Види сите</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate"><?php echo e($activity->title ?? ''); ?></p>
                        <p class="text-gray-500 text-xs"><?php echo e($activity->created_at?->diffForHumans() ?? 'Нема датум'); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Нема активности за прикажување.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни соопштенија</h3>
            <a href="<?php echo e(route('admin.announcements.index')); ?>" class="text-blue-600 text-sm hover:underline">Види сите</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentAnnouncements ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate"><?php echo e($announcement->title ?? ''); ?></p>
                        <p class="text-gray-500 text-xs"><?php echo e($announcement->published_at?->diffForHumans() ?? $announcement->created_at?->diffForHumans() ?? 'Нема датум'); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Нема соопштенија за прикажување.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни барања за посета</h3>
            <a href="<?php echo e(route('admin.visit-schedules')); ?>" class="text-blue-600 text-sm hover:underline">Отвори распоред</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentVisitRequests ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start justify-between gap-4 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate"><?php echo e(trim(($request->visitor_first_name ?? '') . ' ' . ($request->visitor_last_name ?? ''))); ?></p>
                        <p class="text-gray-500 text-xs"><?php echo e($request->visit_date?->format('d.m.Y') ?? 'Без датум'); ?> · <?php echo e($request->visitSchedule?->group_name ?? 'Без распоред'); ?></p>
                    </div>
                    <span class="shrink-0 rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700"><?php echo e($request->status ?? '—'); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Нема барања за посета.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Последни рачни изработки</h3>
            <a href="<?php echo e(route('admin.izrabotki')); ?>" class="text-blue-600 text-sm hover:underline">Уреди страница</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentHandcrafts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $handcraft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start gap-3 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="w-2 h-2 bg-orange-600 rounded-full mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-gray-800 font-medium text-sm truncate"><?php echo e($handcraft->title_mk ?? ''); ?></p>
                        <p class="text-gray-500 text-xs"><?php echo e($handcraft->published_at?->diffForHumans() ?? $handcraft->created_at?->diffForHumans() ?? 'Нема датум'); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Нема рачни изработки за прикажување.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>