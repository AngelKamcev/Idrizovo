

<?php $__env->startSection('title', $handcraft->title_mk . ' - Идризово'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $resolveUrl = function (?string $u): string {
        $u = (string) $u;
        if ($u === '') {
            return '';
        }
        if (preg_match('/^https?:\/\//i', $u)) {
            return $u;
        }
        if (str_starts_with($u, '/storage/') || str_starts_with($u, 'storage/')) {
            return asset(ltrim($u, '/'));
        }
        if (preg_match('#^(images|documents)/#', $u)) {
            return asset($u);
        }
        return asset('storage/'.ltrim($u, '/'));
    };
?>

<!-- Hero Section -->
<section class="relative w-full py-12 md:py-20 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900">
    <div class="max-w-6xl mx-auto px-6">
        <div class="mb-8">
            <a href="<?php echo e(route('izrabotki')); ?>" class="text-slate-400 hover:text-white text-sm font-medium inline-flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Назад на Рачни Изработки
            </a>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
            <?php echo e($handcraft->title_mk); ?>

        </h1>
        <p class="mt-6 text-lg text-slate-300 max-w-2xl leading-relaxed">
            <?php echo nl2br(e($handcraft->description_mk)); ?>

        </p>
        <div class="mt-6 text-sm text-slate-400">
            Објавено: <time datetime="<?php echo e($handcraft->published_at?->format('Y-m-d')); ?>">
                <?php echo e($handcraft->published_at?->format('d.m.Y') ?? 'N/A'); ?>

            </time>
        </div>
    </div>
</section>

<!-- Main Image -->
<section class="py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="rounded-2xl overflow-hidden shadow-2xl h-96 md:h-[500px]">
            <img 
                src="<?php echo e($resolveUrl($handcraft->image_url)); ?>" 
                alt="<?php echo e($handcraft->title_mk); ?>"
                class="w-full h-full object-cover"
            />
        </div>
    </div>
</section>

<!-- Gallery Section -->
<?php if($handcraft->images->count() > 0): ?>
<section class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">
            Галерија (<?php echo e($handcraft->images->count()); ?> слики)
        </h2>
        
        <!-- Desktop Grid -->
        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $handcraft->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 h-72">
                    <img 
                        src="<?php echo e($resolveUrl($image->image_url)); ?>"
                        alt="Слика <?php echo e($loop->iteration); ?>"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    />
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button 
                            type="button"
                            onclick="openImageModal('<?php echo e($resolveUrl($image->image_url)); ?>')"
                            class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition"
                        >
                            Пошირока
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Mobile Carousel -->
        <div class="md:hidden overflow-x-auto pb-4">
            <div class="flex gap-4">
                <?php $__currentLoopData = $handcraft->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex-shrink-0 w-80 h-64 rounded-xl overflow-hidden shadow-md">
                        <img 
                            src="<?php echo e($resolveUrl($image->image_url)); ?>"
                            alt="Слика <?php echo e($loop->iteration); ?>"
                            class="w-full h-full object-cover"
                        />
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4">
    <div class="max-w-4xl w-full relative">
        <img id="modalImage" src="" alt="" class="w-full rounded-lg" />
        <button 
            type="button"
            onclick="closeImageModal()"
            class="absolute top-4 right-4 bg-white text-black rounded-full p-2 hover:bg-gray-200 transition"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<!-- Related Handcrafts -->
<?php
    $relatedHandcrafts = \App\Models\Handcraft::query()
        ->where('is_published', true)
        ->where('id', '!=', $handcraft->id)
        ->inRandomOrder()
        ->limit(3)
        ->get();
?>

<?php if($relatedHandcrafts->count() > 0): ?>
<section class="py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">
            Други Рачни Изработки
        </h2>
        
        <div class="grid md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $relatedHandcrafts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $craft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a 
                    href="<?php echo e(route('handcraft.detail', $craft)); ?>"
                    class="group overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 bg-white"
                >
                    <div class="h-64 overflow-hidden">
                        <img 
                            src="<?php echo e($resolveUrl($craft->image_url)); ?>"
                            alt="<?php echo e($craft->title_mk); ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                        />
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition">
                            <?php echo e($craft->title_mk); ?>

                        </h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                            <?php echo e($craft->description_mk); ?>

                        </p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Close modal on background click
document.getElementById('imageModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'imageModal') {
        closeImageModal();
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Idrizovo\backend\resources\views/handcraft-detail.blade.php ENDPATH**/ ?>