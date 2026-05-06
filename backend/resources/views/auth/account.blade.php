@extends('layouts.auth')

@section('title', 'Мој профил')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-semibold mb-2">Мој профил</h1>
        <p class="text-sm text-gray-600">Можете да ја промените вашата корисничка име, е-пошта и лозинка.</p>
        <p class="text-sm text-gray-500 mt-2">Ваш тип: {{ auth()->user()->role?->name ?? 'N/A' }}</p>
    </div>

    @if(session('status'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('account.update') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-1">Корисничко име</label>
            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required class="w-full rounded border border-gray-300 px-4 py-2">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Е-пошта</label>
            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full rounded border border-gray-300 px-4 py-2">
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="current_password" class="block text-sm font-medium mb-1">Тековна лозинка</label>
                <input id="current_password" name="current_password" type="password" class="w-full rounded border border-gray-300 px-4 py-2">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium mb-1">Нова лозинка</label>
                <input id="password" name="password" type="password" class="w-full rounded border border-gray-300 px-4 py-2">
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1">Потврди нова лозинка</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded border border-gray-300 px-4 py-2">
        </div>

        <button type="submit" class="w-full py-3 bg-[#2e589e] text-white rounded-lg font-semibold hover:bg-[#24477e]">Зачувај промени</button>
    </form>
</div>
@endsection
