@extends('admin.layouts.app')

@section('title', 'Уреди Соопштење')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Уреди Соопштење</h1>
        <a href="{{ route('admin.announcements.index') }}" class="text-blue-600 hover:text-blue-900">← Назад</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PATCH')

        {{-- ── MACEDONIAN (source) ── --}}
        <div class="mb-4">
            <label for="title_mk" class="block text-sm font-medium text-gray-700 mb-2">Наслов (Македонски) <span class="text-red-500">*</span></label>
            <input type="text" id="title_mk" name="title_mk"
                   value="{{ old('title_mk', $announcement->getTranslation('title', 'mk')) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="content_mk" class="block text-sm font-medium text-gray-700 mb-2">Содржина (Македонски) <span class="text-red-500">*</span></label>
            <textarea id="content_mk" name="content_mk" rows="8" required
                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('content_mk', $announcement->getTranslation('content', 'mk')) }}</textarea>
        </div>

        {{-- ── AI TRANSLATE BUTTON ── --}}
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-blue-800 font-medium">
                    🌐 Преведи автоматски на Англиски и Албански
                </p>
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
            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                Наслов (Англиски)
                <span class="text-xs text-gray-400 ml-1">— уредете или преведете со AI</span>
            </label>
            <input type="text" id="title_en" name="title_en"
                   value="{{ old('title_en', $announcement->getTranslation('title', 'en')) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 bg-gray-50">
        </div>

        <div class="mb-6">
            <label for="content_en" class="block text-sm font-medium text-gray-700 mb-2">Содржина (Англиски)</label>
            <textarea id="content_en" name="content_en" rows="8"
                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 bg-gray-50">{{ old('content_en', $announcement->getTranslation('content', 'en')) }}</textarea>
        </div>

        {{-- ── ALBANIAN ── --}}
        <div class="mb-4">
            <label for="title_sq" class="block text-sm font-medium text-gray-700 mb-2">Наслов (Албански)</label>
            <input type="text" id="title_sq" name="title_sq"
                   value="{{ old('title_sq', $announcement->getTranslation('title', 'sq')) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 bg-gray-50">
        </div>

        <div class="mb-6">
            <label for="content_sq" class="block text-sm font-medium text-gray-700 mb-2">Содржина (Албански)</label>
            <textarea id="content_sq" name="content_sq" rows="8"
                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 bg-gray-50">{{ old('content_sq', $announcement->getTranslation('content', 'sq')) }}</textarea>
        </div>

        {{-- ── IMAGE ── --}}
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Слика</label>

            @if ($announcement->getImageUrl())
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Тековна слика:</p>
                    <img src="{{ $announcement->getImageUrl() }}" alt="слика" class="h-32 w-auto object-cover rounded border border-gray-300">
                </div>
            @endif

            <input type="file" id="image" name="image" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">Оставете празно ако не сакате да менувате слика.</p>
        </div>

        {{-- ── OPTIONS ── --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Редослед</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $announcement->sort_order) }}" min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }} class="rounded">
                    <span class="ml-2 text-sm text-gray-700">Активно</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Зачувај Измени
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                Откажи
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('translateBtn').addEventListener('click', async function () {
    const titleMk   = document.getElementById('title_mk').value.trim();
    const contentMk = document.getElementById('content_mk').value.trim();

    if (!titleMk && !contentMk) {
        alert('Внесете Наслов или Содржина на македонски пред да преведувате.');
        return;
    }

    const btn      = this;
    const icon     = document.getElementById('translateBtnIcon');
    const btnText  = document.getElementById('translateBtnText');
    const status   = document.getElementById('translateStatus');

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
                fields: { title: titleMk, content: contentMk },
                from:   'mk',
            }),
        });

        if (!response.ok) {
            const err = await response.json().catch(() => ({}));
            throw new Error(err.error ?? `HTTP ${response.status}`);
        }

        const data = await response.json();

        if (data.en) {
            document.getElementById('title_en').value   = data.en.title   ?? '';
            document.getElementById('content_en').value = data.en.content ?? '';
        }
        if (data.sq) {
            document.getElementById('title_sq').value   = data.sq.title   ?? '';
            document.getElementById('content_sq').value = data.sq.content ?? '';
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
