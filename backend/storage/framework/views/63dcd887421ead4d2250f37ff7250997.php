<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Преглед на системот и брз пристап до содржината'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $user = auth()->user();
    $isAdmin = $user?->isAdmin();
    $isReviewer = $user?->isReviewer();
    $visitStatusLabels = [
        'approved'              => 'Одобрено',
        'Одобрено'             => 'Одобрено',
        'cancelled_by_visitor'  => 'Откажано (посетител)',
        'cancelled_by_admin'    => 'Откажано (админ)',
        'completed'             => 'Завршено',
        'no_show'               => 'Не се појавил',
    ];
?>


<?php if($hasAlerts ?? false): ?>
<div class="db-alert-banner">
    <div class="db-alert-header">
        <div class="db-alert-icon">
            <i class="fas fa-bell"></i>
        </div>
        <div>
            <h3 class="db-alert-title">Потребно е внимание</h3>
            <p class="db-alert-sub">Нови пораки или посети за денес</p>
        </div>
    </div>

    <div class="db-alert-chips">
        <?php if(($canSeeContactAlerts ?? false) && ($newComplaintsCount ?? 0) > 0): ?>
            <a href="<?php echo e($isReviewer ? route('admin.complaints') : route('admin.reviewer-dashboard')); ?>" class="db-chip db-chip--red">
                <span>Нови жалби</span>
                <span class="db-chip-badge"><?php echo e($newComplaintsCount); ?></span>
            </a>
        <?php endif; ?>
        <?php if(($canSeeContactAlerts ?? false) && ($newComplimentsCount ?? 0) > 0): ?>
            <a href="<?php echo e(route('admin.compliments')); ?>" class="db-chip db-chip--green">
                <span>Нови пофалби</span>
                <span class="db-chip-badge"><?php echo e($newComplimentsCount); ?></span>
            </a>
        <?php endif; ?>
        <?php if($isAdmin && ($visitRequestsSubmittedToday ?? 0) > 0): ?>
            <a href="<?php echo e(route('admin.visit-requests')); ?>" class="db-chip db-chip--sky">
                <span>Нови барања денес</span>
                <span class="db-chip-badge"><?php echo e($visitRequestsSubmittedToday); ?></span>
            </a>
        <?php endif; ?>
        <?php if($isAdmin && ($visitsScheduledToday ?? 0) > 0): ?>
            <a href="<?php echo e(route('admin.visit-requests')); ?>" class="db-chip db-chip--blue">
                <span>Посети за денес</span>
                <span class="db-chip-badge"><?php echo e($visitsScheduledToday); ?></span>
            </a>
        <?php endif; ?>
    </div>

    <?php if($isAdmin && ($urgentVisitRequests ?? collect())->isNotEmpty()): ?>
        <div class="db-alert-list-section">
            <p class="db-alert-list-label">Барања / посети за денес</p>
            <ul class="db-alert-list">
                <?php $__currentLoopData = $urgentVisitRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="db-alert-list-item">
                        <i class="fas fa-calendar-day db-alert-list-icon"></i>
                        <span>
                            <strong><?php echo e(trim($visit->visitor_first_name.' '.$visit->visitor_last_name)); ?></strong>
                            — термин <?php echo e($visit->visit_date?->format('d.m.Y') ?? '—'); ?>

                            <span class="db-alert-list-meta">(<?php echo e($visitStatusLabels[$visit->status] ?? $visit->status); ?>)</span>
                        </span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(($canSeeContactAlerts ?? false) && ($urgentNewComplaints ?? collect())->isNotEmpty()): ?>
        <div class="db-alert-list-section">
            <p class="db-alert-list-label">Нови жалби</p>
            <ul class="db-alert-list">
                <?php $__currentLoopData = $urgentNewComplaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="db-alert-list-item">
                        <i class="fas fa-exclamation-circle db-alert-list-icon db-alert-list-icon--red"></i>
                        <span>
                            <strong><?php echo e($complaint->submitted_by_name); ?></strong>
                            — <?php echo e(\Illuminate\Support\Str::limit($complaint->subject, 60)); ?>

                        </span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>



<p class="db-section-label">Содржина</p>
<div class="db-grid-4 mb-section">

    <div class="db-stat-card">
        <div class="db-stat-icon db-stat-icon--blue">
            <i class="fas fa-list"></i>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Активности</span>
            <span class="db-stat-value"><?php echo e($activitiesCount ?? 0); ?></span>
            <span class="db-stat-hint">Главни активности на почетната</span>
        </div>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-icon db-stat-icon--green">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Соопштенија</span>
            <span class="db-stat-value"><?php echo e($announcementsCount ?? 0); ?></span>
            <span class="db-stat-hint">Објавени записи во системот</span>
        </div>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-icon db-stat-icon--purple">
            <i class="fas fa-images"></i>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Галерија</span>
            <span class="db-stat-value"><?php echo e($galleryCount ?? 0); ?></span>
            <span class="db-stat-hint">Активни слики во галеријата</span>
        </div>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-icon db-stat-icon--orange">
            <i class="fas fa-hammer"></i>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Рачни изработки</span>
            <span class="db-stat-value"><?php echo e($handcraftsCount ?? 0); ?></span>
            <span class="db-stat-hint">Објавени изработки</span>
        </div>
    </div>

</div>



<p class="db-section-label">Посети и контакт</p>
<div class="db-grid-4 mb-section">

    <div class="db-stat-card <?php echo e($isAdmin && ($visitRequestsSubmittedToday ?? 0) > 0 ? 'db-stat-card--highlight-sky' : ''); ?>">
        <div class="db-stat-icon db-stat-icon--sky">
            <i class="fas fa-calendar-check"></i>
            <?php if($isAdmin && ($visitRequestsSubmittedToday ?? 0) > 0): ?>
                <span class="db-stat-badge"><?php echo e($visitRequestsSubmittedToday); ?></span>
            <?php endif; ?>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Барања за посета</span>
            <span class="db-stat-value"><?php echo e($visitRequestsCount ?? 0); ?></span>
            <?php if($isAdmin && ($visitRequestsSubmittedToday ?? 0) > 0): ?>
                <span class="db-stat-hint db-stat-hint--sky"><?php echo e($visitRequestsSubmittedToday); ?> нови денес · вкупно</span>
            <?php else: ?>
                <span class="db-stat-hint">Вкупно поднесени барања</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-icon db-stat-icon--emerald">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Одобрени барања</span>
            <span class="db-stat-value"><?php echo e($approvedRequestsCount ?? 0); ?></span>
            <span class="db-stat-hint">Посети со статус Одобрено</span>
        </div>
    </div>

    <div class="db-stat-card <?php echo e(($canSeeContactAlerts ?? false) && ($newComplaintsCount ?? 0) > 0 ? 'db-stat-card--highlight-red' : ''); ?>">
        <div class="db-stat-icon db-stat-icon--red">
            <i class="fas fa-comments"></i>
            <?php if(($canSeeContactAlerts ?? false) && ($newComplaintsCount ?? 0) > 0): ?>
                <span class="db-stat-badge db-stat-badge--red"><?php echo e($newComplaintsCount); ?></span>
            <?php endif; ?>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Жалби</span>
            <span class="db-stat-value"><?php echo e($complaintsCount ?? 0); ?></span>
            <?php if(($canSeeContactAlerts ?? false) && ($newComplaintsCount ?? 0) > 0): ?>
                <span class="db-stat-hint db-stat-hint--red"><?php echo e($newComplaintsCount); ?> нови · вкупно</span>
            <?php else: ?>
                <span class="db-stat-hint">Непроцесирани и процесирани</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-icon db-stat-icon--amber">
            <i class="fas fa-thumbs-up"></i>
        </div>
        <div class="db-stat-body">
            <span class="db-stat-label">Пофалби</span>
            <span class="db-stat-value"><?php echo e($complimentsCount ?? 0); ?></span>
            <span class="db-stat-hint">Сите пристигнати пофалби</span>
        </div>
    </div>

</div>



<div class="db-grid-3col mb-section">

    
    <div class="db-card">
        <div class="db-card-header">
            <i class="fas fa-bolt db-card-header-icon db-card-header-icon--yellow"></i>
            <h3 class="db-card-title">Брзи дејства</h3>
        </div>
        <div class="db-actions-grid">
            <a href="<?php echo e(route('admin.main-activities.create')); ?>" class="db-action-btn db-action-btn--primary">
                <i class="fas fa-plus-circle"></i>
                <span>Нова активност</span>
            </a>
            <a href="<?php echo e(route('admin.announcements.create')); ?>" class="db-action-btn db-action-btn--primary">
                <i class="fas fa-file-circle-plus"></i>
                <span>Ново соопштение</span>
            </a>
            <a href="<?php echo e(route('admin.gallery.create')); ?>" class="db-action-btn db-action-btn--primary">
                <i class="fas fa-image"></i>
                <span>Нова слика</span>
            </a>
            <a href="<?php echo e(route('admin.izrabotki')); ?>" class="db-action-btn db-action-btn--primary">
                <i class="fas fa-hammer"></i>
                <span>Уреди изработки</span>
            </a>
            <a href="<?php echo e(route('admin.aboutus')); ?>" class="db-action-btn db-action-btn--secondary">
                <i class="fas fa-info-circle"></i>
                <span>Уреди „За Нас"</span>
            </a>
            <a href="<?php echo e(route('admin.visit-schedules')); ?>" class="db-action-btn db-action-btn--secondary">
                <i class="fas fa-clock"></i>
                <span>Распоред на посети</span>
            </a>
            <?php if($isAdmin): ?>
                <a href="<?php echo e(route('admin.visit-requests')); ?>" class="db-action-btn db-action-btn--secondary">
                    <i class="fas fa-calendar-check"></i>
                    <span>Барања за посета</span>
                </a>
                <a href="<?php echo e(route('admin.reviewer-dashboard')); ?>" class="db-action-btn db-action-btn--secondary">
                    <i class="fas fa-comments"></i>
                    <span>Жалби и пофалби</span>
                </a>
            <?php elseif($isReviewer): ?>
                <a href="<?php echo e(route('admin.reviewer-dashboard')); ?>" class="db-action-btn db-action-btn--secondary">
                    <i class="fas fa-comments"></i>
                    <span>Жалби и пофалби</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="db-card db-card--span2">
        <div class="db-card-header">
            <i class="fas fa-server db-card-header-icon db-card-header-icon--green"></i>
            <h3 class="db-card-title">Статус на системот</h3>
        </div>
        <div class="db-status-grid">
            <div class="db-status-item">
                <div class="db-status-left">
                    <span class="db-status-dot <?php echo e(($webServerStatus ?? false) ? 'db-status-dot--green' : 'db-status-dot--red'); ?>"></span>
                    <span class="db-status-name">Веб сервер</span>
                </div>
                <span class="db-status-badge <?php echo e(($webServerStatus ?? false) ? 'db-status-badge--green' : 'db-status-badge--red'); ?>">
                    <?php echo e(($webServerStatus ?? false) ? 'Активен' : 'Недостапен'); ?>

                </span>
            </div>
            <div class="db-status-item">
                <div class="db-status-left">
                    <span class="db-status-dot <?php echo e(($databaseStatus ?? false) ? 'db-status-dot--green' : 'db-status-dot--red'); ?>"></span>
                    <span class="db-status-name">База на податоци</span>
                </div>
                <span class="db-status-badge <?php echo e(($databaseStatus ?? false) ? 'db-status-badge--green' : 'db-status-badge--red'); ?>">
                    <?php echo e(($databaseStatus ?? false) ? 'Поврзана' : 'Грешка'); ?>

                </span>
            </div>
            <div class="db-status-item">
                <div class="db-status-left">
                    <span class="db-status-dot <?php echo e(($storageStatus ?? false) ? 'db-status-dot--green' : 'db-status-dot--red'); ?>"></span>
                    <span class="db-status-name">Галерија и содржини</span>
                </div>
                <span class="db-status-badge <?php echo e(($storageStatus ?? false) ? 'db-status-badge--green' : 'db-status-badge--red'); ?>">
                    <?php echo e(($storageStatus ?? false) ? 'Синхронизирани' : 'Грешка'); ?>

                </span>
            </div>
            <div class="db-status-item">
                <div class="db-status-left">
                    <span class="db-status-dot <?php echo e(($handcraftsStatus ?? false) ? 'db-status-dot--green' : 'db-status-dot--red'); ?>"></span>
                    <span class="db-status-name">Рачни изработки</span>
                </div>
                <span class="db-status-badge <?php echo e(($handcraftsStatus ?? false) ? 'db-status-badge--green' : 'db-status-badge--red'); ?>">
                    <?php echo e(($handcraftsStatus ?? false) ? 'Активни' : 'Грешка'); ?>

                </span>
            </div>
        </div>
    </div>

</div>



<div class="db-grid-2col mb-section">

    <div class="db-card">
        <div class="db-card-header db-card-header--between">
            <div class="db-card-header-left">
                <i class="fas fa-list db-card-header-icon db-card-header-icon--blue"></i>
                <h3 class="db-card-title">Последни активности</h3>
            </div>
            <a href="<?php echo e(route('admin.main-activities.index')); ?>" class="db-card-link">Види сите →</a>
        </div>
        <ul class="db-feed">
            <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="db-feed-item">
                    <span class="db-feed-dot db-feed-dot--blue"></span>
                    <div class="db-feed-body">
                        <p class="db-feed-title"><?php echo e($activity->title ?? ''); ?></p>
                        <p class="db-feed-meta"><?php echo e($activity->created_at?->diffForHumans() ?? 'Нема датум'); ?></p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="db-feed-empty">Нема активности за прикажување.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="db-card">
        <div class="db-card-header db-card-header--between">
            <div class="db-card-header-left">
                <i class="fas fa-newspaper db-card-header-icon db-card-header-icon--green"></i>
                <h3 class="db-card-title">Последни соопштенија</h3>
            </div>
            <a href="<?php echo e(route('admin.announcements.index')); ?>" class="db-card-link">Види сите →</a>
        </div>
        <ul class="db-feed">
            <?php $__empty_1 = true; $__currentLoopData = $recentAnnouncements ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="db-feed-item">
                    <span class="db-feed-dot db-feed-dot--green"></span>
                    <div class="db-feed-body">
                        <p class="db-feed-title"><?php echo e($announcement->title ?? ''); ?></p>
                        <p class="db-feed-meta"><?php echo e($announcement->published_at?->diffForHumans() ?? $announcement->created_at?->diffForHumans() ?? 'Нема датум'); ?></p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="db-feed-empty">Нема соопштенија за прикажување.</li>
            <?php endif; ?>
        </ul>
    </div>

</div>



<div class="db-grid-2col">

    <div class="db-card">
        <div class="db-card-header db-card-header--between">
            <div class="db-card-header-left">
                <i class="fas fa-calendar-check db-card-header-icon db-card-header-icon--sky"></i>
                <h3 class="db-card-title">Последни барања за посета</h3>
            </div>
            <?php if($isAdmin): ?>
                <a href="<?php echo e(route('admin.visit-requests')); ?>" class="db-card-link">Види сите →</a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.visit-schedules')); ?>" class="db-card-link">Отвори распоред →</a>
            <?php endif; ?>
        </div>
        <ul class="db-feed">
            <?php $__empty_1 = true; $__currentLoopData = $recentVisitRequests ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="db-feed-item db-feed-item--between">
                    <div class="db-feed-body">
                        <p class="db-feed-title"><?php echo e(trim(($request->visitor_first_name ?? '') . ' ' . ($request->visitor_last_name ?? ''))); ?></p>
                        <p class="db-feed-meta"><?php echo e($request->visit_date?->format('d.m.Y') ?? 'Без датум'); ?> · <?php echo e($request->visitSchedule?->group_name ?? 'Без распоред'); ?></p>
                    </div>
                    <span class="db-status-pill"><?php echo e($request->status ?? '—'); ?></span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="db-feed-empty">Нема барања за посета.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="db-card">
        <div class="db-card-header db-card-header--between">
            <div class="db-card-header-left">
                <i class="fas fa-hammer db-card-header-icon db-card-header-icon--orange"></i>
                <h3 class="db-card-title">Последни рачни изработки</h3>
            </div>
            <a href="<?php echo e(route('admin.izrabotki')); ?>" class="db-card-link">Уреди страница →</a>
        </div>
        <ul class="db-feed">
            <?php $__empty_1 = true; $__currentLoopData = $recentHandcrafts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $handcraft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="db-feed-item">
                    <span class="db-feed-dot db-feed-dot--orange"></span>
                    <div class="db-feed-body">
                        <p class="db-feed-title"><?php echo e($handcraft->title_mk ?? ''); ?></p>
                        <p class="db-feed-meta"><?php echo e($handcraft->published_at?->diffForHumans() ?? $handcraft->created_at?->diffForHumans() ?? 'Нема датум'); ?></p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="db-feed-empty">Нема рачни изработки за прикажување.</li>
            <?php endif; ?>
        </ul>
    </div>

</div>



<style>
/* ── Tokens ─────────────────────────────────────────── */
:root {
    --db-radius:      12px;
    --db-radius-sm:   8px;
    --db-radius-xs:   6px;
    --db-shadow:      0 1px 3px rgba(0,0,0,.07), 0 4px 12px rgba(0,0,0,.06);
    --db-shadow-lg:   0 2px 8px rgba(0,0,0,.08), 0 8px 24px rgba(0,0,0,.08);
    --db-border:      1px solid #e8ecf0;
    --db-gap:         20px;
    --db-gap-sm:      12px;
}

/* ── Layout helpers ──────────────────────────────────── */
.mb-section  { margin-bottom: 28px; }
.db-grid-4   { display: grid; gap: var(--db-gap); grid-template-columns: repeat(4, 1fr); }
.db-grid-2col{ display: grid; gap: var(--db-gap); grid-template-columns: 1fr 1fr; }
.db-grid-3col{ display: grid; gap: var(--db-gap); grid-template-columns: 1fr 2fr; }

@media (max-width: 1199px) {
    .db-grid-4    { grid-template-columns: repeat(2, 1fr); }
    .db-grid-3col { grid-template-columns: 1fr; }
    .db-card--span2 { grid-column: 1; }
}
@media (max-width: 767px) {
    .db-grid-4    { grid-template-columns: 1fr 1fr; }
    .db-grid-2col { grid-template-columns: 1fr; }
    .db-grid-3col { grid-template-columns: 1fr; }
}
@media (max-width: 479px) {
    .db-grid-4 { grid-template-columns: 1fr; }
}

/* ── Section label ───────────────────────────────────── */
.db-section-label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 10px;
}

/* ── Base card ───────────────────────────────────────── */
.db-card {
    background: #fff;
    border: var(--db-border);
    border-radius: var(--db-radius);
    padding: 22px 24px;
    box-shadow: var(--db-shadow);
}
.db-card--span2 { grid-column: span 2; }
@media (max-width: 1199px) { .db-card--span2 { grid-column: 1; } }

/* ── Card header ─────────────────────────────────────── */
.db-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
}
.db-card-header--between {
    justify-content: space-between;
}
.db-card-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.db-card-header-icon {
    width: 30px;
    height: 30px;
    border-radius: var(--db-radius-xs);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    flex-shrink: 0;
}
.db-card-header-icon--blue   { background: #dbeafe; color: #2563eb; }
.db-card-header-icon--green  { background: #dcfce7; color: #16a34a; }
.db-card-header-icon--sky    { background: #e0f2fe; color: #0284c7; }
.db-card-header-icon--orange { background: #ffedd5; color: #ea580c; }
.db-card-header-icon--yellow { background: #fef9c3; color: #ca8a04; }

.db-card-title {
    font-size: .95rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.db-card-link {
    font-size: .78rem;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    white-space: nowrap;
}
.db-card-link:hover { color: #1d4ed8; text-decoration: underline; }

/* ── Stat card ───────────────────────────────────────── */
.db-stat-card {
    background: #fff;
    border: var(--db-border);
    border-radius: var(--db-radius);
    padding: 20px;
    box-shadow: var(--db-shadow);
    display: flex;
    gap: 16px;
    align-items: flex-start;
    transition: box-shadow .15s ease, transform .15s ease;
}
.db-stat-card:hover {
    box-shadow: var(--db-shadow-lg);
    transform: translateY(-1px);
}
.db-stat-card--highlight-sky { border-color: #7dd3fc; box-shadow: 0 0 0 2px #bae6fd, var(--db-shadow); }
.db-stat-card--highlight-red { border-color: #fca5a5; box-shadow: 0 0 0 2px #fecaca, var(--db-shadow); }

.db-stat-icon {
    position: relative;
    width: 46px;
    height: 46px;
    border-radius: var(--db-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.db-stat-icon--blue    { background: #dbeafe; color: #2563eb; }
.db-stat-icon--green   { background: #dcfce7; color: #16a34a; }
.db-stat-icon--purple  { background: #f3e8ff; color: #9333ea; }
.db-stat-icon--orange  { background: #ffedd5; color: #ea580c; }
.db-stat-icon--sky     { background: #e0f2fe; color: #0284c7; }
.db-stat-icon--emerald { background: #d1fae5; color: #059669; }
.db-stat-icon--red     { background: #fee2e2; color: #dc2626; }
.db-stat-icon--amber   { background: #fef3c7; color: #d97706; }

.db-stat-badge {
    position: absolute;
    top: -5px; right: -5px;
    min-width: 18px; height: 18px;
    padding: 0 4px;
    border-radius: 999px;
    background: #0284c7;
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
}
.db-stat-badge--red { background: #dc2626; }

.db-stat-body {
    display: flex;
    flex-direction: column;
    gap: 1px;
    min-width: 0;
}
.db-stat-label { font-size: .78rem; color: #64748b; font-weight: 500; }
.db-stat-value { font-size: 1.75rem; font-weight: 800; color: #0f172a; line-height: 1.15; }
.db-stat-hint  { font-size: .72rem; color: #94a3b8; margin-top: 2px; }
.db-stat-hint--sky { color: #0284c7; font-weight: 600; }
.db-stat-hint--red { color: #dc2626; font-weight: 600; }

/* ── Quick actions ───────────────────────────────────── */
.db-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.db-action-btn {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 9px 12px;
    border-radius: var(--db-radius-sm);
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .12s ease, transform .1s ease;
}
.db-action-btn:hover { transform: translateY(-1px); }
.db-action-btn i { font-size: .8rem; flex-shrink: 0; }
.db-action-btn--primary  { background: #2f5fa8; color: #fff; }
.db-action-btn--primary:hover  { background: #264f90; }
.db-action-btn--secondary { background: #f1f5f9; color: #334155; }
.db-action-btn--secondary:hover { background: #e2e8f0; }

/* ── System status ───────────────────────────────────── */
.db-status-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 600px) { .db-status-grid { grid-template-columns: 1fr; } }

.db-status-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: var(--db-border);
    border-radius: var(--db-radius-sm);
    padding: 12px 16px;
    gap: 10px;
}
.db-status-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.db-status-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.db-status-dot--green  { background: #22c55e; box-shadow: 0 0 0 3px #dcfce7; }
.db-status-name { font-size: .83rem; color: #334155; font-weight: 500; }

.db-status-badge {
    font-size: .72rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    white-space: nowrap;
}
.db-status-badge--green { background: #dcfce7; color: #15803d; }

/* ── Feed list ───────────────────────────────────────── */
.db-feed { list-style: none; margin: 0; padding: 0; }
.db-feed-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
}
.db-feed-item:last-child { border-bottom: none; padding-bottom: 0; }
.db-feed-item--between {
    justify-content: space-between;
    align-items: center;
}
.db-feed-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    margin-top: 5px;
    flex-shrink: 0;
}
.db-feed-dot--blue   { background: #3b82f6; }
.db-feed-dot--green  { background: #22c55e; }
.db-feed-dot--orange { background: #f97316; }

.db-feed-body { min-width: 0; flex: 1; }
.db-feed-title { font-size: .84rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; }
.db-feed-meta  { font-size: .73rem; color: #94a3b8; margin: 2px 0 0; }
.db-feed-empty { font-size: .83rem; color: #94a3b8; padding: 12px 0; }

.db-status-pill {
    flex-shrink: 0;
    background: #f1f5f9;
    color: #475569;
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 999px;
    white-space: nowrap;
}

/* ── Alert banner ────────────────────────────────────── */
.db-alert-banner {
    background: #fffbeb;
    border: 2px solid #fcd34d;
    border-radius: var(--db-radius);
    padding: 22px 24px;
    margin-bottom: 28px;
}
.db-alert-header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
}
.db-alert-icon {
    width: 38px; height: 38px;
    background: #f59e0b;
    border-radius: var(--db-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    flex-shrink: 0;
    font-size: .9rem;
}
.db-alert-title { font-size: 1rem; font-weight: 700; color: #78350f; margin: 0; }
.db-alert-sub   { font-size: .78rem; color: #92400e; margin: 2px 0 0; }

.db-alert-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}
.db-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid #fde68a;
    border-radius: var(--db-radius-sm);
    padding: 8px 14px;
    font-size: .82rem;
    font-weight: 600;
    color: #1e293b;
    text-decoration: none;
    transition: border-color .12s;
}
.db-chip:hover { border-color: #f59e0b; }
.db-chip-badge {
    min-width: 22px;
    height: 22px;
    padding: 0 5px;
    border-radius: 999px;
    color: #fff;
    font-size: .73rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}
.db-chip--red   .db-chip-badge { background: #ef4444; }
.db-chip--green .db-chip-badge { background: #22c55e; }
.db-chip--sky   .db-chip-badge { background: #0ea5e9; }
.db-chip--blue  .db-chip-badge { background: #2f5fa8; }

.db-alert-list-section { margin-top: 10px; }
.db-alert-list-label {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #92400e;
    margin-bottom: 8px;
}
.db-alert-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 6px; }
.db-alert-list-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    background: rgba(255,255,255,.7);
    border: 1px solid #fde68a;
    border-radius: var(--db-radius-xs);
    padding: 9px 12px;
    font-size: .83rem;
    color: #1e293b;
}
.db-alert-list-icon     { color: #d97706; margin-top: 2px; flex-shrink: 0; font-size: .8rem; }
.db-alert-list-icon--red { color: #ef4444; }
.db-alert-list-meta { color: #6b7280; }
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>