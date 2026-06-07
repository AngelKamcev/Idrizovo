@extends('admin.layouts.app')

@section('title', 'Нова активност')
@section('page-title', 'Нова активност')
@section('page-subtitle', 'Создајте нова активност за почетната страна')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.main-activities.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Назад на активности
    </a>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('admin.main-activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ── MACEDONIAN ── --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Назив на активност <span class="text-red-500">*</span></label>
            <input type="text" name="title_mk" value="{{ old('title_mk') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('title_mk') border-red-500 @enderror"
                   placeholder="Напишите назив на активност" required>
            @error('title_mk')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис <span class="text-red-500">*</span></label>
            <textarea name="description_mk" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('description_mk') border-red-500 @enderror"
                      placeholder="Напишите опис на активност" required>{{ old('description_mk') }}</textarea>
            @error('description_mk')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- ── AI TRANSLATE BUTTON ── --}}
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-blue-800 font-medium">🌐 Преведи автоматски на Англиски и Албански</p>
                <button type="button" id="translateBtn"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded transition">
                    <span id="translateBtnIcon">✨</span>
                    <span id="translateBtnText">Преведи со AI</span>
                </button>
            </div>
            <p id="translateStatus" class="text-xs text-blue-600 mt-2 hidden"></p>
        </div>

        {{-- ── ENGLISH ── --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Назив (Англиски) <span class="text-xs text-gray-400 ml-1">— пополнува се автоматски или рачно</span>
            </label>
            <input type="text" name="title_en" value="{{ old('title_en') }}"
                   id="title_en"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис (Англиски)</label>
            <textarea name="description_en" id="description_en" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50">{{ old('description_en') }}</textarea>
        </div>

        {{-- ── ALBANIAN ── --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Назив (Албански)</label>
            <input type="text" name="title_sq" value="{{ old('title_sq') }}"
                   id="title_sq"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Опис (Албански)</label>
            <textarea name="description_sq" id="description_sq" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50">{{ old('description_sq') }}</textarea>
        </div>

        {{-- ── REST OF FIELDS ── --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Содржина</label>
            <textarea name="content" rows="6"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('content') border-red-500 @enderror"
                      placeholder="Дополнителна содржина (опционално)">{{ old('content') }}</textarea>
            @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Слика</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('image') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Максимална величина: 2MB (JPEG, PNG, GIF)</p>
            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Икона (Font Awesome class)</label>
            <input type="text" name="icon" value="{{ old('icon') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="fas fa-star">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Редослед за приказ</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded">
                <span class="text-sm font-semibold text-gray-700">Активна активност</span>
            </label>
        </div>

        <div class="flex gap-3 justify-end">
            <a href="{{ route('admin.main-activities.index') }}" class="btn-secondary">
                <i class="fas fa-times mr-2"></i> Откажи
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> Создај активност
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('translateBtn').addEventListener('click', async function () {
    const titleMk = document.querySelector('[name="title_mk"]').value.trim();
    const descMk  = document.querySelector('[name="description_mk"]').value.trim();

    if (!titleMk && !descMk) {
        alert('Внесете Назив или Опис на македонски пред да преведувате.');
        return;
    }

    const btn     = this;
    const icon    = document.getElementById('translateBtnIcon');
    const btnText = document.getElementById('translateBtnText');
    const status  = document.getElementById('translateStatus');

    btn.disabled = true;
    icon.textContent = '⏳';
    btnText.textContent = 'Преведување…';
    status.textContent = 'Се поврзувам со AI сервисот…';
    status.classList.remove('hidden');

    try {
        const response = await fetch('{{ route('admin.translate') }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                fields: { title: titleMk, description: descMk },
                from:   'mk',
            }),
        });

        if (!response.ok) {
            const err = await response.json().catch(() => ({}));
            throw new Error(err.error ?? `HTTP ${response.status}`);
        }

        const data = await response.json();

        if (data.en) {
            document.getElementById('title_en').value       = data.en.title       ?? '';
            document.getElementById('description_en').value = data.en.description ?? '';
        }
        if (data.sq) {
            document.getElementById('title_sq').value       = data.sq.title       ?? '';
            document.getElementById('description_sq').value = data.sq.description ?? '';
        }

        icon.textContent    = '✅';
        btnText.textContent = 'Преведено!';
        status.textContent  = 'Преводот е завршен. Можете да ги уредите полињата пред да зачувате.';
        status.classList.replace('text-blue-600', 'text-green-600');

    } catch (err) {
        icon.textContent    = '❌';
        btnText.textContent = 'Грешка';
        status.textContent  = 'Неуспешно преведување: ' + err.message;
        status.classList.replace('text-blue-600', 'text-red-600');
    } finally {
        setTimeout(() => {
            btn.disabled        = false;
            icon.textContent    = '✨';
            btnText.textContent = 'Преведи со AI';
        }, 3000);
    }
});
</script>

@endsection
