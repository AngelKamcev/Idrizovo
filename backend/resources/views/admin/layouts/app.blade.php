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
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 13px 16px;
            border-radius: 16px;
            color: rgba(255,255,255,0.76);
            font-size: 14px;
            font-weight: 600;
            transition: all .25s ease;
        }

        .sidebar-link i {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.10);
            color: rgba(255,255,255,0.82);
            transition: all .25s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.12);
            transform: translateX(4px);
        }

        .sidebar-link:hover i {
            background: rgba(255,255,255,0.18);
            color: #ffffff;
        }

        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(111,150,216,0.95), rgba(47,95,168,0.95));
            box-shadow: 0 18px 35px rgba(8,21,41,.20);
        }

        .sidebar-link.active i {
            background: rgba(255,255,255,0.22);
            color: #ffffff;
        }

        .section-title {
            padding: 22px 16px 10px;
            color: rgba(255,255,255,0.45);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .16em;
        }

        .btn-primary {
            @apply bg-[#2f5fa8] hover:bg-[#244f91] text-white px-4 py-2 rounded-lg transition-all;
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
            @apply bg-white rounded-2xl shadow-md p-6 border border-gray-100;
        }
        .table-row:hover {
            @apply bg-gray-50;
        }
    </style>
</head>
<body class="bg-[#f5f7fb]">
    <div class="min-h-screen lg:flex bg-[#f5f7fb]">

        <!-- MOBILE TOP NAV -->
        <div class="lg:hidden sticky top-0 z-50 bg-[#081529] px-5 py-4 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#9fb7dc] to-[#2f5fa8] flex items-center justify-center shadow-lg">
                        <i class="fas fa-lock text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-white text-lg font-bold leading-none">Admin</h1>
                        <p class="text-white/50 text-[11px] mt-1">Идризово панел</p>
                    </div>
                </div>

                <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
                        class="w-11 h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center border border-white/10">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav id="mobileMenu" class="hidden mt-5 pb-2 space-y-2">
                <a href="/admin/dashboard" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span>Dashboard</span>
                </a>
                <a href="/admin/activities" class="sidebar-link {{ request()->is('admin/activities') ? 'active' : '' }}">
                    <i class="fas fa-list"></i><span>Активности (Почетна)</span>
                </a>
                <a href="/admin/soopstenija" class="sidebar-link {{ request()->is('admin/soopstenija') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i><span>Соопштенија</span>
                </a>
                <a href="/admin/izrabotki" class="sidebar-link {{ request()->is('admin/izrabotki') ? 'active' : '' }}">
                    <i class="fas fa-hammer"></i><span>Рачни Изработки</span>
                </a>
                <a href="/admin/gallery" class="sidebar-link {{ request()->is('admin/gallery') ? 'active' : '' }}">
                    <i class="fas fa-images"></i><span>Галерија</span>
                </a>
                <a href="/admin/aboutus" class="sidebar-link {{ request()->is('admin/aboutus') ? 'active' : '' }}">
                    <i class="fas fa-info-circle"></i><span>За Нас</span>
                </a>
                <a href="/admin/main-activities" class="sidebar-link {{ request()->is('admin/main-activities') ? 'active' : '' }}">
                    <i class="fas fa-calendar"></i><span>Активности</span>
                </a>
                <a href="/" class="sidebar-link">
                    <i class="fas fa-sign-out-alt"></i><span>Одјава</span>
                </a>
            </nav>
        </div>

        <!-- DESKTOP SIDEBAR -->
        <aside class="hidden lg:flex w-[320px] min-h-screen bg-[#081529] text-white flex-col sticky top-0">
            <div class="relative overflow-hidden h-full flex flex-col">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,#6f96d8_0%,transparent_38%),linear-gradient(to_bottom,#081529_0%,#0b1a2b_100%)] opacity-95"></div>
                <div class="absolute top-0 right-0 w-[180px] h-[180px] bg-[#6f96d8]/20 rounded-full blur-3xl"></div>

                <!-- HEADER -->
                <div class="relative z-10 px-7 pt-8 pb-7 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#9fb7dc] to-[#2f5fa8] flex items-center justify-center shadow-2xl shadow-black/20">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-[24px] font-bold leading-tight">Admin</h1>
                            <p class="text-[12px] text-white/50 mt-1">Управување на содржина</p>
                        </div>
                    </div>
                </div>

                <!-- NAVIGATION -->
                <nav class="relative z-10 flex-1 overflow-y-auto px-5 py-6 space-y-1">
                    <a href="/admin/dashboard" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i><span>Dashboard</span>
                    </a>

                    <div class="section-title">Содржина</div>

                    <a href="/admin/activities" class="sidebar-link {{ request()->is('admin/activities') ? 'active' : '' }}">
                        <i class="fas fa-list"></i><span>Активности (Почетна)</span>
                    </a>

                    <a href="/admin/soopstenija" class="sidebar-link {{ request()->is('admin/soopstenija') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i><span>Соопштенија</span>
                    </a>

                    <a href="/admin/izrabotki" class="sidebar-link {{ request()->is('admin/izrabotki') ? 'active' : '' }}">
                        <i class="fas fa-hammer"></i><span>Рачни Изработки</span>
                    </a>

                    <a href="/admin/gallery" class="sidebar-link {{ request()->is('admin/gallery') ? 'active' : '' }}">
                        <i class="fas fa-images"></i><span>Галерија</span>
                    </a>

                    <a href="/admin/aboutus" class="sidebar-link {{ request()->is('admin/aboutus') ? 'active' : '' }}">
                        <i class="fas fa-info-circle"></i><span>За Нас</span>
                    </a>

                    <a href="/admin/main-activities" class="sidebar-link {{ request()->is('admin/main-activities') ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i><span>Активности</span>
                    </a>

                    <div class="section-title">Систем</div>

                    <a href="/" class="sidebar-link">
                        <i class="fas fa-cog"></i><span>Поставки</span>
                    </a>

                    <a href="/" class="sidebar-link">
                        <i class="fas fa-sign-out-alt"></i><span>Одјава</span>
                    </a>
                </nav>

                <!-- FOOTER USER CARD -->
                <div class="relative z-10 p-5 border-t border-white/10">
                    <div class="rounded-3xl bg-white/10 border border-white/10 p-4 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-white/15 flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white truncate">Администратор</p>
                            <p class="text-[11px] text-white/50">{{ date('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 flex flex-col">
            <!-- TOP BAR -->
            <div class="hidden lg:flex bg-white/85 backdrop-blur-md border-b border-gray-200 px-10 py-5 items-center justify-between sticky top-0 z-40">
                <div>
                    <h2 class="text-[28px] font-bold text-[#0b1a2b] leading-tight">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-500 mt-1">@yield('page-subtitle', '')</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-[#0b1a2b]">Администратор</p>
                        <p class="text-xs text-gray-500">{{ date('d.m.Y') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-[#6f96d8] to-[#2f5fa8] rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
            </div>

            <!-- MOBILE PAGE TITLE -->
            <div class="lg:hidden px-5 pt-7 pb-3">
                <h2 class="text-[24px] font-bold text-[#0b1a2b] leading-tight">@yield('page-title', 'Dashboard')</h2>
                <p class="text-sm text-gray-500 mt-1">@yield('page-subtitle', '')</p>
            </div>

            <!-- PAGE CONTENT -->
            <div class="flex-1 p-5 md:p-8 lg:p-10 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
