<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Idrizovo')</title>
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
</head>
<body class="min-h-screen bg-[#eef2ff] text-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg">
            @yield('content')
        </div>
    </div>
</body>
</html>
