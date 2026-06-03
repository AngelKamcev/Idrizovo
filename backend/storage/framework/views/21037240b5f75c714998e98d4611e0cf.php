<?php $__env->startSection('title', 'Рачни Изработки'); ?>
<?php $__env->startSection('page-title', 'Рачни Изработки'); ?>
<?php $__env->startSection('page-subtitle', 'Картички и слики од компјутер'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $imgUrl = function (?string $p): string {
        $p = (string) $p;
        if ($p === '') return '';
        if (preg_match('#^https?://#i', $p)) return $p;
        if (str_starts_with($p, 'izrabotki/')) return asset('storage/'.$p);
        return asset(ltrim($p, '/'));
    };
    $sections = $data['sections'] ?? [];
    while (count($sections) < 4) {
        $sections[] = ['layout' => 'images_left', 'title' => '', 'body' => '', 'main_image' => '', 'strip_images' => []];
    }
    $sections = array_slice($sections, 0, 4);
    $mobileCards = $data['mobile_cards'] ?? [];
    while (count($mobileCards) < 3) {
        $mobileCards[] = ['image' => '', 'title' => '', 'body' => ''];
    }
    $mobileCards = array_slice($mobileCards, 0, 3);
    $scrollText = old('scroll_quotes_text', implode("\n", $data['scroll_quotes'] ?? []));
?>

<?php if(session('success')): ?>
<div class="mb-6 flex items-center gap-3 rounded-lg border border-[#c9a84c]/30 bg-[#faf6ed] px-4 py-3 text-sm text-[#7a5c10]">
    <svg class="w-4 h-4 text-[#c9a84c] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
    <ul class="list-inside list-disc space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($err); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?php echo e(route('admin.izrabotki.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
<?php echo csrf_field(); ?>


<div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#ddd9d0] flex items-center gap-3">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Позадина · Hero</h3>
    </div>
    <div class="p-6">
        <input type="hidden" name="hero_bg_existing" value="<?php echo e(old('hero_bg_existing', $data['hero_bg'] ?? '')); ?>">
        <?php if(!empty($data['hero_bg'])): ?>
        <div class="mb-5">
            <p class="text-xs font-medium text-[#888] uppercase tracking-widest mb-2">Тековна слика</p>
            <div class="h-44 w-full max-w-lg overflow-hidden rounded-lg border border-[#ddd9d0] bg-cover bg-center"
                 style="background-image: url('<?php echo e($imgUrl($data['hero_bg'])); ?>')"></div>
        </div>
        <?php endif; ?>
        <label class="block text-xs font-medium text-[#555] mb-2">Нова слика (остави празно за да остане постоечката)</label>
        <input type="file" name="hero_upload" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
               class="block w-full max-w-md text-xs text-[#666] file:mr-3 file:rounded file:border-0 file:bg-[#0E1B2F] file:px-4 file:py-2 file:text-xs file:font-medium file:text-white hover:file:bg-[#1e3251]">
        <p class="mt-2 text-xs text-[#aaa]">Препорака: широка слика.</p>
    </div>
</div>


<div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">
    <div class="px-6 py-4 border-b border-[#ddd9d0] flex items-center gap-3">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Текст на страната</h3>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Наслов на вовед <span class="text-[#aaa] font-normal">(празно = превод)</span></label>
            <input type="text" name="intro_title" value="<?php echo e(old('intro_title', $data['intro_title'] ?? '')); ?>"
                   class="w-full max-w-2xl rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">
        </div>
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Вовед (текст)</label>
            <textarea name="intro_body" rows="4"
                      class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30" required><?php echo e(old('intro_body', $data['intro_body'] ?? '')); ?></textarea>
        </div>
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Цитат <span class="text-[#aaa] font-normal">(празно = стандарден превод)</span></label>
            <textarea name="quote" rows="2"
                      class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30"><?php echo e(old('quote', $data['quote'] ?? '')); ?></textarea>
        </div>
        <div>
            <label class="block text-xs font-medium text-[#555] mb-1.5">Лента со цитати <span class="text-[#aaa] font-normal">(еден цитат по ред)</span></label>
            <textarea name="scroll_quotes_text" rows="6"
                      class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 font-mono text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30"><?php echo e($scrollText); ?></textarea>
        </div>
    </div>
</div>


<div>
    <div class="flex items-center gap-3 mb-5">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Работилници · Десктоп</h3>
        <span class="text-xs text-[#aaa]">4 картички</span>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">

            <div class="px-5 py-3 bg-[#0E1B2F] flex items-center justify-between">
                <span class="text-xs font-semibold text-white tracking-widest uppercase">Картичка <?php echo e($i + 1); ?></span>
                <select name="sections[<?php echo e($i); ?>][layout]"
                        class="rounded border border-white/20 bg-white/10 px-2 py-1 text-xs text-white focus:outline-none">
                    <option value="images_left" <?php if(old("sections.$i.layout", $sec['layout'] ?? '') === 'images_left'): echo 'selected'; endif; ?>>Слики лево</option>
                    <option value="images_right" <?php if(old("sections.$i.layout", $sec['layout'] ?? '') === 'images_right'): echo 'selected'; endif; ?>>Слики десно</option>
                </select>
            </div>

            <div class="p-5 space-y-5">

                
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-[#888] mb-2">Главна слика</p>
                    <input type="hidden" name="main_existing_<?php echo e($i); ?>" value="<?php echo e(old("main_existing_$i", $sec['main_image'] ?? '')); ?>">
                    <?php if(!empty($sec['main_image'])): ?>
                        <img src="<?php echo e($imgUrl($sec['main_image'])); ?>" alt=""
                             class="mb-2 h-28 w-full rounded-lg border border-[#ddd9d0] object-cover">
                    <?php else: ?>
                        <div class="mb-2 flex h-28 items-center justify-center rounded-lg border border-dashed border-[#d4cfc4] bg-white text-xs text-[#aaa]">
                            Нема слика
                        </div>
                    <?php endif; ?>
                    <input type="file" name="main_upload_<?php echo e($i); ?>" accept="image/*"
                           class="block w-full text-xs text-[#666] file:mr-2 file:rounded file:border-0 file:bg-[#0E1B2F] file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-[#1e3251]">
                </div>

                
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-[#888] mb-2">Хармоника — 4 слики</p>
                    <div class="grid grid-cols-2 gap-2">
                        <?php for($j = 0; $j < 4; $j++): ?>
                            <?php $stripPath = $sec['strip_images'][$j] ?? ''; ?>
                            <div class="rounded-lg border border-[#ddd9d0] bg-white p-2.5">
                                <p class="mb-1.5 text-[9px] font-bold uppercase tracking-widest text-[#c9a84c]"><?php echo e($j + 1); ?></p>
                                <input type="hidden" name="strip_existing_<?php echo e($i); ?>_<?php echo e($j); ?>"
                                       value="<?php echo e(old("strip_existing_{$i}_{$j}", $stripPath)); ?>">
                                <?php if($stripPath !== ''): ?>
                                    <img src="<?php echo e($imgUrl($stripPath)); ?>" alt=""
                                         class="mb-1.5 h-16 w-full rounded object-cover border border-[#ddd9d0]">
                                <?php else: ?>
                                    <div class="mb-1.5 flex h-16 items-center justify-center rounded border border-dashed border-[#d4cfc4] bg-[#f5f3ef] text-[9px] text-[#bbb]">—</div>
                                <?php endif; ?>
                                <input type="file" name="strip_upload_<?php echo e($i); ?>_<?php echo e($j); ?>" accept="image/*"
                                       class="block w-full text-[10px] text-[#666] file:mr-1 file:rounded file:border-0 file:bg-[#f5f3ef] file:px-1.5 file:py-0.5 file:text-[10px]">
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                
                <div class="space-y-2.5">
                    <input type="text" name="sections[<?php echo e($i); ?>][title]"
                           value="<?php echo e(old("sections.$i.title", $sec['title'] ?? '')); ?>"
                           placeholder="Наслов"
                           class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">
                    <textarea name="sections[<?php echo e($i); ?>][body]" rows="4"
                              placeholder="Текст"
                              class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30" required><?php echo e(old("sections.$i.body", $sec['body'] ?? '')); ?></textarea>
                </div>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<div>
    <div class="flex items-center gap-3 mb-5">
        <div class="w-1 h-5 bg-[#c9a84c]"></div>
        <h3 class="text-sm font-semibold text-[#0E1B2F] tracking-wide uppercase">Мобилни картички</h3>
        <span class="text-xs text-[#aaa]">3 картички</span>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <?php $__currentLoopData = $mobileCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-xl border border-[#ddd9d0] bg-[#f5f3ef] overflow-hidden">

            <div class="px-5 py-3 bg-[#0E1B2F]">
                <span class="text-xs font-semibold text-white tracking-widest uppercase">Картичка <?php echo e($i + 1); ?></span>
            </div>

            <div class="p-5 space-y-3">
                <input type="hidden" name="mobile_image_existing_<?php echo e($i); ?>"
                       value="<?php echo e(old("mobile_image_existing_$i", $card['image'] ?? '')); ?>">
                <?php if(!empty($card['image'])): ?>
                    <img src="<?php echo e($imgUrl($card['image'])); ?>" alt=""
                         class="h-36 w-full rounded-lg border border-[#ddd9d0] object-cover">
                <?php else: ?>
                    <div class="flex h-36 items-center justify-center rounded-lg border border-dashed border-[#d4cfc4] bg-white text-xs text-[#aaa]">
                        Нема слика
                    </div>
                <?php endif; ?>
                <input type="file" name="mobile_image_upload_<?php echo e($i); ?>" accept="image/*"
                       class="block w-full text-xs text-[#666] file:mr-2 file:rounded file:border-0 file:bg-[#0E1B2F] file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-[#1e3251]">
                <input type="text" name="mobile_cards[<?php echo e($i); ?>][title]"
                       value="<?php echo e(old("mobile_cards.$i.title", $card['title'] ?? '')); ?>"
                       placeholder="Наслов (празно = превод)"
                       class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30">
                <textarea name="mobile_cards[<?php echo e($i); ?>][body]" rows="3"
                          placeholder="Текст"
                          class="w-full rounded-lg border border-[#ddd9d0] bg-white px-3 py-2.5 text-sm text-[#0E1B2F] focus:border-[#c9a84c] focus:outline-none focus:ring-1 focus:ring-[#c9a84c]/30"><?php echo e(old("mobile_cards.$i.body", $card['body'] ?? '')); ?></textarea>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<div class="flex items-center justify-end gap-4 border-t border-[#ddd9d0] pt-6">
    <span class="text-xs text-[#aaa]">Сите промени се зачувуваат одеднаш</span>
    <button type="submit"
            class="inline-flex items-center gap-2 bg-[#0E1B2F] text-white text-xs font-medium tracking-widest uppercase px-8 py-3 rounded-lg hover:bg-[#1e3251] transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        Зачувај
    </button>
</div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views\admin\izrabotki.blade.php ENDPATH**/ ?>