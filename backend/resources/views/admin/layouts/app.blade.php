<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Идризово</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .sidebar-link {
            @apply text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent hover:text-blue-600 transition-all flex items-center gap-4 text-sm font-medium;
        }
        .sidebar-link i {
            @apply flex-shrink-0 w-5 h-5 text-center;
        }
        .sidebar-link span {
            @apply flex-shrink-0;
        }
        .sidebar-link.active {
            @apply bg-gradient-to-r from-blue-50 to-transparent text-blue-700 border-l-4 border-blue-600 pl-2 font-semibold;
        }
        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all;
        }
        .btn-secondary {
            @apply bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-all;
        }
        .btn-danger {
            @apply bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all;
        }
        .btn-edit {
            @apply bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded text-sm transition-all;
        }
        .card {
            @apply bg-white rounded-lg shadow-md p-6 border border-gray-100;
        }
        .table-row:hover {
            @apply bg-gray-50;
        }
        .section-title {
            @apply px-3 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- SIDEBAR -->
        <div class="w-96 bg-white border-r border-gray-200 overflow-y-auto flex flex-col">
            <!-- HEADER -->
            <div class="p-6 border-b border-gray-200 sticky top-0 bg-white">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lock text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800">Admin</h1>
                </div>
                <p class="text-xs text-gray-500 pl-13">Управување на содржина</p>
            </div>

            <!-- NAVIGATION -->
            <nav class="flex-1 py-4 px-2 space-y-1">
                <!-- Dashboard -->
                <a href="/admin/dashboard" class="sidebar-link active rounded-r-lg px-3 py-3">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <div class="section-title">Содржина</div>

                <!-- Index Activities -->
                <a href="/admin/activities" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-list"></i>
                    <span>Активности (Почетна)</span>
                </a>

                <!-- Soopstenija -->
                <a href="/admin/soopstenija" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-newspaper"></i>
                    <span>Соопштенија</span>
                </a>

                <!-- Racni Izrabotki -->
                <a href="/admin/izrabotki" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-hammer"></i>
                    <span>Рачни Изработки</span>
                </a>

                <!-- Gallery -->
                <a href="/admin/gallery" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-images"></i>
                    <span>Галерија</span>
                </a>

                <!-- About Us -->
                <a href="/admin/aboutus" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-info-circle"></i>
                    <span>За Нас</span>
                </a>

                <!-- Activities (Main) -->
                <a href="/admin/main-activities" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-calendar"></i>
                    <span>Активности</span>
                </a>

                <div class="section-title">Система</div>

                <!-- Settings -->
                <a href="/" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-cog"></i>
                    <span>Поставки</span>
                </a>

                <!-- Logout -->
                <a href="/" class="sidebar-link rounded-r-lg px-3 py-3">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Одјава</span>
                </a>
            </nav>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- TOP BAR -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-600">@yield('page-subtitle', '')</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">Администратор</p>
                        <p class="text-xs text-gray-500">{{ date('d.m.Y') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
