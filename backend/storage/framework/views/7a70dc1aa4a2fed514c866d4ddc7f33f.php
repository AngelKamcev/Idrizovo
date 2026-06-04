<!DOCTYPE html>
<html lang="mk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Идризово'); ?></title>
    
    <link href="<?php echo e(asset('css/output.css')); ?>" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap"></noscript>
    
    <script src="https://cdn.tailwindcss.com" defer></script>
    <script src="https://kit.fontawesome.com/0ebb078a69.js" crossorigin="anonymous" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease;
        }

        #mobile-menu.open {
            max-height: 500px;
        }

        .mob-sub {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .mob-sub.open {
            max-height: 200px;
        }

    </style>
</head>

<body class="bg-white text-black flex flex-col min-h-screen">
    <?php
        $navAnnouncements = \Illuminate\Support\Facades\Cache::remember('nav_announcements', 300, function () {
            return \App\Models\Announcement::active()->published()->sorted()->take(5)->get();
        });
    ?>

    <div class="hidden md:flex bg-[#2e589e] text-[12px] py-2 px-40 justify-between items-center text-white">
        <div class="flex flex-wrap space-x-30">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span>02 25 80 312</span>
            </div>
            <div class="flex items-center space-x-2 pl-40">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>kpuidrizovo@kpuidrizovo.gov.mk</span>
            </div>
            <div class="flex items-center space-x-2 pl-40">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>ул.1 колонија Идризово бр.4А</span>
            </div>
        </div>
        
        <!-- Language Selector -->
        <div class="relative inline-block text-left group">
            <button class="flex items-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white cursor-pointer hover:opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
            </button>
            <div class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-[100] ring-1 ring-black ring-opacity-5 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all">
                <a href="<?php echo e(localized_url('mk')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 flex items-center gap-2 <?php echo e(is_locale_active('mk') ? 'bg-blue-50 font-semibold text-blue-600' : ''); ?>">🇲🇰 Македонски</a>
                <a href="<?php echo e(localized_url('en')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 flex items-center gap-2 <?php echo e(is_locale_active('en') ? 'bg-blue-50 font-semibold text-blue-600' : ''); ?>">🇬🇧 English</a>
                <a href="<?php echo e(localized_url('sq')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 flex items-center gap-2 <?php echo e(is_locale_active('sq') ? 'bg-blue-50 font-semibold text-blue-600' : ''); ?>">🇦🇱 Shqip</a>
            </div>
        </div>
    </div>

    <nav class="bg-[#2e589e] border-b border-blue-400/30 text-white relative">
        <div class="flex justify-between items-center px-4 md:px-40 py-4">
            <a href="<?php echo e(route('index')); ?>" class="flex items-center">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="h-10 w-auto object-contain">
            </a>

            <ul class="hidden md:flex space-x-9 text-sm font-medium">
                <li>
                    <a href="<?php echo e(route('index')); ?>" class="border-b-2 <?php echo e(Route::currentRouteName() === 'index' ? 'border-blue-300' : 'border-transparent hover:border-blue-300'); ?> pb-1 transition-all">
                        <?php echo e(__('home')); ?>

                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('aboutus')); ?>" class="border-b-2 <?php echo e(Route::currentRouteName() === 'aboutus' ? 'border-blue-300' : 'border-transparent hover:border-blue-300'); ?> pb-1 transition-all">
                        <?php echo e(__('about')); ?>

                    </a>
                </li>
                <li class="relative group">
                    <button class="flex items-center border-b-2 border-transparent group-hover:border-blue-300 pb-1 transition-all outline-none">
                        <span><?php echo e(__('news_and_announcements')); ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-white text-black rounded-md shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="py-2">
                            <a href="<?php echo e(route('soopstenija')); ?>" class="block px-4 py-2 hover:bg-gray-100"><?php echo e(__('announcements')); ?></a>
                            <a href="<?php echo e(route('activities')); ?>" class="block px-4 py-2 hover:bg-gray-100"><?php echo e(__('activities')); ?></a>
                            <a href="<?php echo e(route('gallery')); ?>" class="block px-4 py-2 hover:bg-gray-100"><?php echo e(__('gallery')); ?></a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="<?php echo e(route('izrabotki')); ?>" class="border-b-2 <?php echo e(Route::currentRouteName() === 'izrabotki' ? 'border-blue-300' : 'border-transparent hover:border-blue-300'); ?> pb-1 transition-all">
                        <?php echo e(__('handmade_items')); ?>

                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('contact')); ?>" class="border-b-2 <?php echo e(Route::currentRouteName() === 'contact' ? 'border-blue-300' : 'border-transparent hover:border-blue-300'); ?> pb-1 transition-all">
                        <?php echo e(__('contact')); ?>

                    </a>
                </li>
            </ul>

            <div class="hidden md:flex items-center space-x-6">
                <form method="GET" action="<?php echo e(route('soopstenija')); ?>" class="group relative">
                    <div class="relative flex items-center h-10 w-6">
                        <input
                            id="navAnnouncementSearch"
                            type="text"
                            name="search"
                            value="<?php echo e(request('search')); ?>"
                            placeholder="<?php echo e(__('search')); ?>..."
                            autocomplete="off"
                            class="absolute right-0 w-0 opacity-0 group-hover:w-40 group-hover:opacity-100 group-hover:pr-10 py-2 border-b border-white bg-[#2e589e] text-white transition-all duration-300 focus:outline-none focus:w-48 z-0 placeholder-white/75"
                        >
                        <button type="submit" aria-label="<?php echo e(__('search')); ?>" class="absolute right-0 text-white z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="absolute right-0 top-full mt-3 w-96 rounded-2xl border border-white/15 bg-[#0e1b2f] shadow-2xl overflow-hidden opacity-0 invisible group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100 transition-all duration-200 z-50">
                        <div class="px-4 py-3 border-b border-white/10">
                            <p class="text-[12px] uppercase tracking-[0.18em] text-white/45">Последни соопштенија</p>
                        </div>
                        <div id="navAnnouncementSearchList" class="max-h-80 overflow-y-auto">
                            <?php $__empty_1 = true; $__currentLoopData = $navAnnouncements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <button
                                    type="button"
                                    class="nav-announcement-item w-full text-left px-4 py-3 border-b border-white/10 hover:bg-white/5 transition"
                                    data-search-text="<?php echo e(mb_strtolower($announcement->getTranslation('title', app()->getLocale()) . ' ' . $announcement->getTranslation('content', app()->getLocale()))); ?>"
                                    data-search-title="<?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>"
                                >
                                    <div class="text-[13px] font-semibold text-white leading-5">
                                        <?php echo e($announcement->getTranslation('title', app()->getLocale())); ?>

                                    </div>
                                    <div class="text-[11px] text-white/55 mt-1 line-clamp-2">
                                        <?php echo e(\Illuminate\Support\Str::limit($announcement->getTranslation('content', app()->getLocale()), 90)); ?>

                                    </div>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="px-4 py-4 text-[13px] text-white/60">Нема соопштенија.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
                <a href="<?php echo e(route('zakazi-poseta')); ?>" class="inline-flex items-center bg-[#0e1b2f] text-white px-6 py-3 text-sm font-bold rounded-xl hover:bg-black transition shadow-md whitespace-nowrap">
                    <?php echo e(__('booking')); ?>

                </a>
            </div>

            <div class="flex md:hidden items-center space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <button id="hamburger" class="text-white focus:outline-none" aria-label="Мени">
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden bg-[#24477e] border-t border-blue-400/30">
            <ul class="flex flex-col text-sm font-medium px-4 py-3 space-y-1">
                <li>
                    <a href="<?php echo e(route('index')); ?>" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition"><?php echo e(__('home')); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(route('aboutus')); ?>" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition"><?php echo e(__('about')); ?></a>
                </li>
                <li>
                    <button id="mob-dropdown-btn" class="w-full flex items-center justify-between py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition">
                        <span><?php echo e(__('news_and_announcements')); ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" id="mob-dropdown-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mob-sub" class="mob-sub">
                        <a href="<?php echo e(route('soopstenija')); ?>" class="block py-2 px-6 text-blue-100 hover:text-white"><?php echo e(__('announcements')); ?></a>
                        <a href="<?php echo e(route('activities')); ?>" class="block py-2 px-6 text-blue-100 hover:text-white"><?php echo e(__('activities')); ?></a>
                        <a href="<?php echo e(route('gallery')); ?>" class="block py-2 px-6 text-blue-100 hover:text-white"><?php echo e(__('gallery')); ?></a>
                    </div>
                </li>
                <li>
                    <a href="<?php echo e(route('izrabotki')); ?>" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition"><?php echo e(__('handmade_items')); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(route('contact')); ?>" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition"><?php echo e(__('contact')); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(route('zakazi-poseta')); ?>" class="block w-full text-left py-3 px-2 bg-[#0e1b2f] text-white rounded font-semibold hover:bg-black transition mt-2">
                        <?php echo e(__('booking')); ?>

                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="flex-grow">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="w-full bg-white">
        <div class="w-full bg-[#2E589E] text-white rounded-t-[40px] md:rounded-none min-h-[216px] flex flex-col md:flex-row items-center justify-between py-12 md:py-0 px-10 md:px-20 relative">
            <div class="flex-shrink-0 mb-10 md:mb-0">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="h-20 mb-12 w-auto object-contain"/>
            </div>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-10 md:gap-12 lg:gap-20 w-full md:w-auto text-center md:text-left">
                <a href="<?php echo e(route('index')); ?>" class="text-[15px] font-normal hover:opacity-80 transition-opacity"><?php echo e(__('home')); ?></a>

                <div class="flex flex-col items-center md:items-start space-y-3">
                    <h3 class="text-[15px] font-normal"><?php echo e(__('about')); ?></h3>
                    <ul class="space-y-2 text-[13px] opacity-80 font-light hidden md:block">
                        <li><a href="<?php echo e(route('aboutus')); ?>#istorija" class="hover:underline"><?php echo e(__('history')); ?></a></li>
                        <li><a href="<?php echo e(route('aboutus')); ?>#vizija" class="hover:underline"><?php echo e(__('vision')); ?></a></li>
                        <li><a href="<?php echo e(route('aboutus')); ?>#misija" class="hover:underline"><?php echo e(__('mission')); ?></a></li>
                    </ul>
                    <div class="md:hidden flex flex-col space-y-2 text-[13px] opacity-80 font-light">
                        <a href="<?php echo e(route('aboutus')); ?>#istorija"><?php echo e(__('history')); ?></a>
                        <a href="<?php echo e(route('aboutus')); ?>#vizija"><?php echo e(__('vision')); ?></a>
                        <a href="<?php echo e(route('aboutus')); ?>#misija"><?php echo e(__('mission')); ?></a>
                    </div>
                </div>

                <div class="flex flex-col items-center md:items-start space-y-3">
                    <h3 class="text-[15px] font-normal"><?php echo e(__('news_and_announcements')); ?></h3>
                    <ul class="space-y-2 text-[13px] opacity-80 font-light hidden md:block">
                        <li><a href="<?php echo e(route('activities')); ?>" class="hover:underline"><?php echo e(__('activities')); ?></a></li>
                        <li><a href="<?php echo e(route('soopstenija')); ?>" class="hover:underline"><?php echo e(__('announcements')); ?></a></li>
                    </ul>
                    <div class="md:hidden flex flex-col space-y-2 text-[13px] opacity-80 font-light">
                        <a href="<?php echo e(route('activities')); ?>"><?php echo e(__('activities')); ?></a>
                        <a href="<?php echo e(route('soopstenija')); ?>"><?php echo e(__('announcements')); ?></a>
                    </div>
                </div>

                <a href="<?php echo e(route('izrabotki')); ?>" class="text-[15px] font-normal hover:opacity-80 transition-opacity"><?php echo e(__('handmade_items')); ?></a>

                <div class="flex flex-col items-center md:items-start space-y-3">
                    <h3 class="text-[15px] font-normal"><?php echo e(__('contact')); ?></h3>
                    <div class="space-y-3 text-[13px] font-light flex flex-col items-center md:items-start">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <span>02 25 80 312</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <span class="break-all">kpuidrizovo@kpuidrizovo.gov.mk</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>ул.1 колонија Идризово бр.4А</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 mt-10 md:mt-0">
                <a href="<?php echo e(route('zakazi-poseta')); ?>" class="inline-block bg-[#111827] text-white px-10 mb-12 py-3 rounded-[4px] text-[15px] font-semibold hover:bg-black transition-all shadow-md">
                    <?php echo e(__('booking')); ?>

                </a>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-[#2E589E] hover:bg-[#1e3a5f] text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 z-50" title="Назад нагоре">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        if (hamburger) {
            hamburger.addEventListener('click', function() {
                mobileMenu.classList.toggle('open');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        }

        // Mobile dropdown toggle
        const mobDropdownBtn = document.getElementById('mob-dropdown-btn');
        const mobSub = document.getElementById('mob-sub');
        const mobDropdownIcon = document.getElementById('mob-dropdown-icon');

        if (mobDropdownBtn) {
            mobDropdownBtn.addEventListener('click', function() {
                mobSub.classList.toggle('open');
                mobDropdownIcon.classList.toggle('rotate-180');
            });
        }

        // Language dropdown toggle
        const langMenuBtn = document.getElementById('lang-menu-btn');
        const langDropdown = document.getElementById('lang-dropdown');

        if (langMenuBtn) {
            langMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                langDropdown.classList.toggle('hidden');
            });
        }

        // Close dropdown when clicking outside
        if (langDropdown) {
            window.addEventListener('click', function() {
                if (!langDropdown.classList.contains('hidden')) {
                    langDropdown.classList.add('hidden');
                }
            });
        }

        const navAnnouncementSearch = document.getElementById('navAnnouncementSearch');
        const navAnnouncementSearchList = document.getElementById('navAnnouncementSearchList');

        if (navAnnouncementSearch && navAnnouncementSearchList) {
            const items = Array.from(navAnnouncementSearchList.querySelectorAll('.nav-announcement-item'));

            const emptyState = document.createElement('div');
            emptyState.id = 'navAnnouncementSearchEmpty';
            emptyState.className = 'px-4 py-4 text-[13px] text-white/60 hidden';
            emptyState.textContent = 'Нема резултати.';
            navAnnouncementSearchList.appendChild(emptyState);

            const filterAnnouncements = () => {
                const query = navAnnouncementSearch.value.trim().toLowerCase();
                let visibleCount = 0;

                items.forEach((item) => {
                    const haystack = item.dataset.searchText || '';
                    const show = query === '' || haystack.includes(query);
                    item.classList.toggle('hidden', !show);
                    if (show) {
                        visibleCount += 1;
                    }
                });

                emptyState.classList.toggle('hidden', visibleCount !== 0);
            };

            navAnnouncementSearch.addEventListener('input', filterAnnouncements);
            filterAnnouncements();

            items.forEach((item) => {
                item.addEventListener('click', () => {
                    navAnnouncementSearch.value = item.dataset.searchTitle || '';
                    navAnnouncementSearch.form.submit();
                });
            });
        }

        // Scroll to Top Button
        const scrollToTopBtn = document.getElementById('scrollToTop');

        if (scrollToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollToTopBtn.classList.remove('opacity-0', 'invisible');
                    scrollToTopBtn.classList.add('opacity-100', 'visible');
                } else {
                    scrollToTopBtn.classList.add('opacity-0', 'invisible');
                    scrollToTopBtn.classList.remove('opacity-100', 'visible');
                }
            });

            scrollToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

    </script>

</body>

</html><?php /**PATH C:\Users\Angel\Desktop\Idrizovo-dimeBackend\backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>