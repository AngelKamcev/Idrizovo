
<?php
    $buttonId = $buttonId ?? 'translateBtn';
    $fieldMap = $fieldMap ?? [];
?>

<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <p class="text-sm text-blue-800 font-medium">🌐 Преведи автоматски на Англиски и Албански</p>
        <button type="button" id="<?php echo e($buttonId); ?>"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded transition">
            <span id="<?php echo e($buttonId); ?>Icon">✨</span>
            <span id="<?php echo e($buttonId); ?>Text">Преведи со AI</span>
        </button>
    </div>
    <p id="<?php echo e($buttonId); ?>Status" class="text-xs text-blue-600 mt-2 hidden"></p>
</div>

<script>
(function () {
    const buttonId = <?php echo json_encode($buttonId, 15, 512) ?>;
    const fieldMap = <?php echo json_encode($fieldMap, 15, 512) ?>;
    const btn = document.getElementById(buttonId);

    if (!btn || btn.dataset.translateBound === '1') {
        return;
    }

    btn.dataset.translateBound = '1';

    btn.addEventListener('click', async function () {
        const fields = {};

        for (const [key, locales] of Object.entries(fieldMap)) {
            const mkInput = document.querySelector(`[name="${locales.mk}"]`);
            fields[key] = mkInput ? mkInput.value.trim() : '';
        }

        if (!Object.values(fields).some(v => v !== '')) {
            alert('Внесете македонски текст пред да преведувате.');
            return;
        }

        const icon = document.getElementById(buttonId + 'Icon');
        const btnText = document.getElementById(buttonId + 'Text');
        const status = document.getElementById(buttonId + 'Status');

        btn.disabled = true;
        icon.textContent = '⏳';
        btnText.textContent = 'Преведување…';
        status.textContent = 'Се поврзувам со AI сервисот…';
        status.classList.remove('hidden', 'text-red-600', 'text-green-600');
        status.classList.add('text-blue-600');

        try {
            const response = await fetch(<?php echo json_encode(route('admin.translate'), 15, 512) ?>, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': <?php echo json_encode(csrf_token(), 15, 512) ?>,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ fields, from: 'mk' }),
            });

            if (!response.ok) {
                const err = await response.json().catch(() => ({}));
                throw new Error(err.error ?? `HTTP ${response.status}`);
            }

            const data = await response.json();

            for (const [key, locales] of Object.entries(fieldMap)) {
                if (data.en && locales.en) {
                    const enInput = document.querySelector(`[name="${locales.en}"]`);
                    if (enInput) enInput.value = data.en[key] ?? '';
                }
                if (data.sq && locales.sq) {
                    const sqInput = document.querySelector(`[name="${locales.sq}"]`);
                    if (sqInput) sqInput.value = data.sq[key] ?? '';
                }
            }

            icon.textContent = '✅';
            btnText.textContent = 'Преведено!';
            status.textContent = 'Преводот е завршен. Можете да ги уредите полињата пред да зачувате.';
            status.classList.replace('text-blue-600', 'text-green-600');
        } catch (err) {
            icon.textContent = '❌';
            btnText.textContent = 'Грешка';
            status.textContent = 'Неуспешно преведување: ' + err.message;
            status.classList.replace('text-blue-600', 'text-red-600');
        } finally {
            setTimeout(() => {
                btn.disabled = false;
                icon.textContent = '✨';
                btnText.textContent = 'Преведи со AI';
            }, 3000);
        }
    });
})();
</script>
<?php /**PATH C:\Users\Angel\Desktop\idrizovo\Idrizovo\backend\resources\views/admin/partials/ai-translate.blade.php ENDPATH**/ ?>