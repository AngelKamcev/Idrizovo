@extends('admin.layouts.app')

@section('title', 'Нова изработка')
@section('page-title', 'Нова изработка')
@section('page-subtitle', 'Додавање наслов, опис и најмалку 4 слики за една изработка')

@section('content')

<form method="POST" action="{{ route('admin.izrabotki.store') }}" enctype="multipart/form-data" class="card max-w-3xl">
    @csrf

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
            <label class="block text-sm font-medium text-gray-700 mb-2">Наслов</label>
            <input type="text" name="title_mk" value="{{ old('title_mk') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Опис</label>
            <textarea name="description_mk" rows="6" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>{{ old('description_mk') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Главна слика</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Дополнителни слики (минимум 3)</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <input type="file" name="extra_image_1" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
                <input type="file" name="extra_image_2" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
                <input type="file" name="extra_image_3" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
            </div>
            <p class="mt-1 text-xs text-gray-500">Овие 3 се задолжителни. Можеш и повеќе подолу.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Плус дополнителни (опционално)</label>
            <input type="file" name="images[]" accept="image/*" multiple class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
            <p class="mt-1 text-xs text-gray-500">Вкупно за секција: 1 главна + 3 или повеќе дополнителни.</p>
        </div>

        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" class="rounded" checked>
            <span class="text-sm text-gray-700">Објави веднаш</span>
        </label>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-primary">Зачувај</button>
        <a href="{{ route('admin.izrabotki') }}" class="btn-secondary">Откажи</a>
    </div>
</form>

@endsection
