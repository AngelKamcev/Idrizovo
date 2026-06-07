@extends('admin.layouts.app')

@section('title', 'Уреди изработка')
@section('page-title', 'Уреди изработка')
@section('page-subtitle', 'Измени наслов/опис и управувај со 4+ слики за секцијата')

@section('content')

<form method="POST" action="{{ route('admin.izrabotki.update', $handcraft) }}" enctype="multipart/form-data" class="card max-w-3xl">
    @csrf
    @method('PATCH')

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Наслов (Македонски) <span class="text-red-500">*</span></label>
            <input type="text" name="title_mk" value="{{ old('title_mk', $handcraft->title_mk) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Опис (Македонски) <span class="text-red-500">*</span></label>
            <textarea name="description_mk" rows="6" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>{{ old('description_mk', $handcraft->description_mk) }}</textarea>
        </div>

        @include('admin.partials.ai-translate', [
            'buttonId' => 'handcraftEditTranslate',
            'fieldMap' => [
                'title' => ['mk' => 'title_mk', 'en' => 'title_en', 'sq' => 'title_al'],
                'description' => ['mk' => 'description_mk', 'en' => 'description_en', 'sq' => 'description_al'],
            ],
        ])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Наслов (Англиски)</label>
                <input type="text" name="title_en" value="{{ old('title_en', $handcraft->title_en) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Наслов (Албански)</label>
                <input type="text" name="title_al" value="{{ old('title_al', $handcraft->title_al) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Опис (Англиски)</label>
                <textarea name="description_en" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50">{{ old('description_en', $handcraft->description_en) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Опис (Албански)</label>
                <textarea name="description_al" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50">{{ old('description_al', $handcraft->description_al) }}</textarea>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Нова главна слика (опционално)</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Додај дополнителни слики</label>
            <input type="file" name="images[]" accept="image/*" multiple class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            <p class="mt-1 text-xs text-gray-500">Мора да останат најмалку 4 слики вкупно (1 главна + 3 дополнителни).</p>
        </div>

        <div class="rounded-lg border border-gray-200 p-3 bg-gray-50">
            <p class="text-sm text-gray-600 mb-2">Тековна слика</p>
            <img src="{{ $handcraft->resolved_image_url }}" alt="{{ $handcraft->title_mk }}" class="h-48 rounded-lg object-cover">
        </div>

        @if($handcraft->images->isNotEmpty())
            <div class="rounded-lg border border-gray-200 p-3 bg-gray-50">
                <p class="text-sm text-gray-700 mb-3">Дополнителни слики (штиклирај за бришење)</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($handcraft->images as $image)
                        <label class="block rounded-lg border border-gray-200 p-2 bg-white cursor-pointer">
                            <img src="{{ $image->resolved_image_url }}" class="h-28 w-full object-cover rounded mb-2" alt="Дополнителна слика">
                            <span class="inline-flex items-center gap-2 text-xs text-gray-700">
                                <input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}" class="rounded">
                                Избриши
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" class="rounded" {{ old('is_published', $handcraft->is_published) ? 'checked' : '' }}>
            <span class="text-sm text-gray-700">Објавено</span>
        </label>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-primary">Зачувај промени</button>
        <a href="{{ route('admin.izrabotki') }}" class="btn-secondary">Назад</a>
    </div>
</form>

@endsection
