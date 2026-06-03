<?php $__env->startSection('title', 'За Нас'); ?>
<?php $__env->startSection('page-title', 'За Нас'); ?>
<?php $__env->startSection('page-subtitle', 'Содржина на страната „За нас" (зачувување во база)'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 20px;
    background: #185FA5;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s;
    text-decoration: none;
}
.btn-primary:hover { background: #0C447C; }
.btn-primary:active { background: #042C53; }

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    background: transparent;
    color: #374151;
    border: 1.5px solid #9CA3AF;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s, border-color .15s;
    text-decoration: none;
}
.btn-secondary:hover {
    background: #F3F4F6;
    border-color: #6B7280;
}

.btn-danger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 10px;
    background: #FCEBEB;
    color: #A32D2D;
    border: 1.5px solid #F09595;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s, border-color .15s;
    line-height: 1;
    white-space: nowrap;
}
.btn-danger:hover {
    background: #F7C1C1;
    border-color: #E24B4A;
    color: #791F1F;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 text-sm">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
        <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($err); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php
    $m = $aboutData['management'][0] ?? ['name' => '', 'title' => '', 'image' => ''];
    $dpty = $aboutData['management'][1] ?? ['name' => '', 'title' => '', 'image' => ''];
    $resolveImageSrc = function (?string $path, string $defaultFolder = 'images'): string {
        $path = (string) $path;

        if ($path === '') {
            return asset($defaultFolder . '/');
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        if (str_starts_with($path, '/storage/') || str_starts_with($path, 'storage/') || str_starts_with($path, 'images/') || str_starts_with($path, 'documents/')) {
            return asset(ltrim($path, '/'));
        }

        return asset($defaultFolder . '/' . ltrim($path, '/'));
    };
?>

<form action="<?php echo e(route('admin.aboutus.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
    <?php echo csrf_field(); ?>

    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Слики</h3>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hero слика од компјутер</label>
                <input type="hidden" name="hero_image_current" value="<?php echo e(old('hero_image_current', $aboutData['hero_image'] ?? '')); ?>">
                <input type="file" name="hero_image_file" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                <?php if(!empty($aboutData['hero_image'])): ?>
                    <img src="<?php echo e($resolveImageSrc($aboutData['hero_image'])); ?>" alt="Hero" class="mt-3 h-28 w-full rounded-lg object-cover border border-gray-200">
                <?php endif; ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Слика до текстот за историја од компјутер</label>
                <input type="hidden" name="history_side_image_current" value="<?php echo e(old('history_side_image_current', $aboutData['history_side_image'] ?? '')); ?>">
                <input type="file" name="history_side_image_file" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                <?php if(!empty($aboutData['history_side_image'])): ?>
                    <img src="<?php echo e($resolveImageSrc($aboutData['history_side_image'])); ?>" alt="Историја" class="mt-3 h-28 w-full rounded-lg object-cover border border-gray-200">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Историја</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Параграф 1</label>
                <textarea name="history_p1" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2" required><?php echo e(old('history_p1', $aboutData['history']['p1'] ?? '')); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Параграф 2</label>
                <textarea name="history_p2" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2" required><?php echo e(old('history_p2', $aboutData['history']['p2'] ?? '')); ?></textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Управа</h3>
        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-3 border border-gray-100 rounded-lg p-4">
                <p class="font-semibold text-gray-700">Директор</p>
                <input type="text" name="director_name" value="<?php echo e(old('director_name', $m['name'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Име" required>
                <input type="text" name="director_title" value="<?php echo e(old('director_title', $m['title'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Функција" required>
                <input type="hidden" name="director_image_current" value="<?php echo e(old('director_image_current', $m['image'] ?? '')); ?>">
                <input type="file" name="director_image_file" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                <?php if(!empty($m['image'])): ?>
                    <img src="<?php echo e($resolveImageSrc($m['image'])); ?>" alt="Директор" class="h-24 w-24 rounded-lg object-cover border border-gray-200">
                <?php endif; ?>
            </div>
            <div class="space-y-3 border border-gray-100 rounded-lg p-4">
                <p class="font-semibold text-gray-700">Заменик директор</p>
                <input type="text" name="deputy_name" value="<?php echo e(old('deputy_name', $dpty['name'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                <input type="text" name="deputy_title" value="<?php echo e(old('deputy_title', $dpty['title'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                <input type="hidden" name="deputy_image_current" value="<?php echo e(old('deputy_image_current', $dpty['image'] ?? '')); ?>">
                <input type="file" name="deputy_image_file" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                <?php if(!empty($dpty['image'])): ?>
                    <img src="<?php echo e($resolveImageSrc($dpty['image'])); ?>" alt="Заменик директор" class="h-24 w-24 rounded-lg object-cover border border-gray-200">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Мисија и визија</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Мисија</label>
                <textarea name="mission" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required><?php echo e(old('mission', $aboutData['mission'] ?? '')); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Визија</label>
                <textarea name="vision" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required><?php echo e(old('vision', $aboutData['vision'] ?? '')); ?></textarea>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Правилник</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Поднаслов</label>
                <input type="text" name="regulation_subtitle" value="<?php echo e(old('regulation_subtitle', $aboutData['regulation']['subtitle'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Текст</label>
                <textarea name="regulation_text" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required><?php echo e(old('regulation_text', $aboutData['regulation']['text'] ?? '')); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PDF (пат од public)</label>
                <input type="text" name="regulation_pdf" value="<?php echo e(old('regulation_pdf', $aboutData['regulation']['pdf'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Брзи информации</h3>
        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Година</label>
                <input type="text" name="foundation_year" value="<?php echo e(old('foundation_year', $aboutData['quick_info']['year'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Капацитет</label>
                <input type="text" name="capacity" value="<?php echo e(old('capacity', $aboutData['quick_info']['capacity'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Адреса</label>
                <input type="text" name="address" value="<?php echo e(old('address', $aboutData['quick_info']['address'] ?? '')); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Одговорни лица</h3>
            <button type="button" id="add-officer" class="btn-secondary">+ Ред</button>
        </div>
        <div id="officers-wrap" class="space-y-4">
            <?php
                $officers = old('officers', $aboutData['responsible_officers'] ?? []);
                if (! is_array($officers)) {
                    $officers = [];
                }
                $officerCount = max(count($officers), 1);
            ?>
            <?php for($i = 0; $i < $officerCount; $i++): ?>
                <?php $o = $officers[$i] ?? ['name' => '', 'role' => '', 'email' => '']; ?>
                <div class="officer-row grid gap-3 md:grid-cols-3 border border-gray-100 rounded-lg p-4">
                    <input type="text" name="officers[<?php echo e($i); ?>][name]" value="<?php echo e($o['name'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-3 py-2" placeholder="Име">
                    <input type="text" name="officers[<?php echo e($i); ?>][role]" value="<?php echo e($o['role'] ?? ''); ?>" class="border border-gray-300 rounded-lg px-3 py-2" placeholder="Функција">
                    <div class="flex gap-2">
                        <input type="email" name="officers[<?php echo e($i); ?>][email]" value="<?php echo e($o['email'] ?? ''); ?>" class="flex-1 border border-gray-300 rounded-lg px-3 py-2" placeholder="E-mail">
                        <button type="button" class="remove-officer btn-danger">× Избриши</button>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">Редови без име се игнорираат. Потребен е барем еден со име.</p>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Сектори</h3>
            <button type="button" id="add-sector" class="btn-secondary">+ Сектор</button>
        </div>
        <div id="sectors-wrap" class="space-y-6">
            <?php
                $sectors = old('sectors', $aboutData['sectors'] ?? []);
                if (! is_array($sectors)) {
                    $sectors = [];
                }
                $sectorCount = max(count($sectors), 1);
            ?>
            <?php for($i = 0; $i < $sectorCount; $i++): ?>
                <?php
                    $s = $sectors[$i] ?? ['img' => '', 'name' => '', 'sub' => []];
                    $subsText = old("sectors.$i.subs_text", isset($s['sub']) && is_array($s['sub']) ? implode("\n", $s['sub']) : '');
                ?>
                <div class="sector-row border border-gray-100 rounded-lg p-4 space-y-3">
                    <div class="flex justify-between items-start gap-2">
                        <p class="font-semibold text-gray-700">Сектор <?php echo e($i + 1); ?></p>
                        <button type="button" class="remove-sector btn-danger">× Избриши</button>
                    </div>
                    <input type="text" name="sectors[<?php echo e($i); ?>][name]" value="<?php echo e($s['name'] ?? ''); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Име на сектор">
                    <input type="hidden" name="sectors[<?php echo e($i); ?>][img_current]" value="<?php echo e($s['img'] ?? ''); ?>">
                    <input type="file" name="sectors[<?php echo e($i); ?>][img_file]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                    <?php if(!empty($s['img'])): ?>
                        <img src="<?php echo e($resolveImageSrc($s['img'])); ?>" alt="Сектор <?php echo e($i + 1); ?>" class="h-24 w-24 rounded-lg object-cover border border-gray-200">
                    <?php endif; ?>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Под-ставки (една по ред)</label>
                        <textarea name="sectors[<?php echo e($i); ?>][subs_text]" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="1. Одделение..."><?php echo e($subsText); ?></textarea>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">Сектори без име се игнорираат. Потребен е барем еден.</p>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">Зачувај во база</button>
    </div>
</form>

<script>
(function () {
    function renumberOfficers() {
        var wrap = document.getElementById('officers-wrap');
        if (!wrap) return;
        wrap.querySelectorAll('.officer-row').forEach(function (row, idx) {
            row.querySelectorAll('[name^="officers["]').forEach(function (inp) {
                inp.name = inp.name.replace(/officers\[\d+\]/, 'officers[' + idx + ']');
            });
        });
    }

    function renumberSectors() {
        var wrap = document.getElementById('sectors-wrap');
        if (!wrap) return;
        wrap.querySelectorAll('.sector-row').forEach(function (row, idx) {
            row.querySelectorAll('[name^="sectors["]').forEach(function (inp) {
                inp.name = inp.name.replace(/sectors\[\d+\]/, 'sectors[' + idx + ']');
            });
        });
    }

    document.getElementById('add-officer')?.addEventListener('click', function () {
        var wrap = document.getElementById('officers-wrap');
        var row = wrap.querySelector('.officer-row');
        if (!row) return;
        var clone = row.cloneNode(true);
        clone.querySelectorAll('input').forEach(function (inp) { inp.value = ''; });
        wrap.appendChild(clone);
        renumberOfficers();
    });

    document.getElementById('officers-wrap')?.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-officer')) return;
        var wrap = document.getElementById('officers-wrap');
        if (wrap.querySelectorAll('.officer-row').length <= 1) return;
        e.target.closest('.officer-row').remove();
        renumberOfficers();
    });

    document.getElementById('add-sector')?.addEventListener('click', function () {
        var wrap = document.getElementById('sectors-wrap');
        var row = wrap.querySelector('.sector-row');
        if (!row) return;
        var clone = row.cloneNode(true);
        clone.querySelectorAll('input, textarea').forEach(function (inp) { inp.value = ''; });
        wrap.appendChild(clone);
        renumberSectors();
    });

    document.getElementById('sectors-wrap')?.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-sector')) return;
        var wrap = document.getElementById('sectors-wrap');
        if (wrap.querySelectorAll('.sector-row').length <= 1) return;
        e.target.closest('.sector-row').remove();
        renumberSectors();
    });
})();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\admin\aboutus.blade.php ENDPATH**/ ?>