<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - Идризово' : 'Идризово'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

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

    <!-- Top bar – скриен на мобилен, видлив md+ -->
    <div class="hidden md:flex bg-[#2e589e] text-[12px] py-2 px-40 justify-between items-center text-white">
        <div class="flex flex-wrap space-x-30">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>02 25 80 312</span>
            </div>
            <div class="flex items-center space-x-2 pl-40">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>kpuidrizovo@kpuidrizovo.gov.mk</span>
            </div>
            <div class="flex items-center space-x-2 pl-40">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>ул.1 колонија Идризово бр.4А</span>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white cursor-pointer hover:opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
        </svg>
    </div>

    <!-- NAVBAR -->
    <nav class="bg-[#2e589e] border-b border-blue-400/30 text-white relative">
        <div class="flex justify-between items-center px-4 md:px-40 py-4">

            <!-- Logo -->
            <a href="index.php" class="flex items-center">
                <img src="logo.png" alt="Logo" class="h-10 w-auto object-contain">
            </a>

            <!-- Desktop links -->
            <ul class="hidden md:flex space-x-10 text-sm font-medium">
                <li>
                    <a href="index.php" class="border-b-2 border-transparent hover:border-blue-300 pb-1 transition-all
                        <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'border-blue-300' : ''; ?>">
                        Дома
                    </a>
                </li>
                <li>
                    <a href="zanas.php" class="border-b-2 border-transparent hover:border-blue-300 pb-1 transition-all
                        <?php echo (basename($_SERVER['PHP_SELF']) === 'zanas.php') ? 'border-blue-300' : ''; ?>">
                        За нас
                    </a>
                </li>
                <li class="relative group">
                    <button class="flex items-center border-b-2 border-transparent group-hover:border-blue-300 pb-1 transition-all outline-none">
                        <span>Новости и соопштенија</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-white text-black rounded-md shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="py-2">
                            <a href="novosti.php" class="block px-4 py-2 hover:bg-gray-100">Најнови вести</a>
                            <a href="sooshtuvanja.php" class="block px-4 py-2 hover:bg-gray-100">Соопштенија</a>
                            <a href="galerija.php" class="block px-4 py-2 hover:bg-gray-100">Галерија</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="izrabotki.php" class="border-b-2 border-transparent hover:border-blue-300 pb-1 transition-all
                        <?php echo (basename($_SERVER['PHP_SELF']) === 'izrabotki.php') ? 'border-blue-300' : ''; ?>">
                        Изработки
                    </a>
                </li>
                <li>
                    <a href="kontakt.php" class="border-b-2 border-transparent hover:border-blue-300 pb-1 transition-all
                        <?php echo (basename($_SERVER['PHP_SELF']) === 'kontakt.php') ? 'border-blue-300' : ''; ?>">
                        Контакт
                    </a>
                </li>
            </ul>

            <!-- Desktop десно: пребарување + копче -->
            <div class="hidden md:flex items-center space-x-6">
                <div class="relative flex items-center group h-10 w-6">
                    <input type="text" placeholder="Пребарај..."
                        class="absolute right-0 w-0 opacity-0 group-hover:w-48 group-hover:opacity-100 group-hover:pr-10 py-2 border-b border-white bg-[#2e589e] text-white transition-all duration-300 focus:outline-none focus:w-48 z-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer absolute right-0 text-white z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button class="bg-[#0e1b2f] text-white px-6 py-3 text-sm font-bold rounded-xl hover:bg-black transition shadow-md whitespace-nowrap">
                    Закажи посета
                </button>
            </div>

            <!-- Мобилен десно: иконка пребарување + хамбургер -->
            <div class="flex md:hidden items-center space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <button id="hamburger" class="text-white focus:outline-none" aria-label="Мени">
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Мобилен dropdown мени -->
        <div id="mobile-menu" class="md:hidden bg-[#24477e] border-t border-blue-400/30">
            <ul class="flex flex-col text-sm font-medium px-4 py-3 space-y-1">
                <li>
                    <a href="index.php" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition">Дома</a>
                </li>
                <li>
                    <a href="zanas.php" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition">За нас</a>
                </li>
                <li>
                    <button id="mob-dropdown-btn" class="w-full flex items-center justify-between py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition">
                        <span>Новости и соопштенија</span>
                        <svg id="mob-arrow" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="mob-sub" class="mob-sub bg-[#1c3a6a] rounded-b-md">
                        <a href="novosti.php" class="block py-2 px-6 hover:text-blue-200 transition border-b border-blue-400/10">Најнови вести</a>
                        <a href="sooshtuvanja.php" class="block py-2 px-6 hover:text-blue-200 transition border-b border-blue-400/10">Соопштенија</a>
                        <a href="galerija.php" class="block py-2 px-6 hover:text-blue-200 transition">Галерија</a>
                    </div>
                </li>
                <li>
                    <a href="izrabotki.php" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition">Изработки</a>
                </li>
                <li>
                    <a href="kontakt.php" class="flex items-center py-3 px-2 border-b border-blue-400/20 hover:text-blue-200 transition">Контакт</a>
                </li>
                <li class="pt-3 pb-2">
                    <button class="w-full bg-[#0e1b2f] text-white px-6 py-3 text-sm font-bold rounded-xl hover:bg-black transition shadow-md">
                        Закажи посета
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Scroll to top -->
    <div onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="text-white fixed bottom-10 right-10 bg-[#2e589e] p-3 rounded-full shadow-lg cursor-pointer hover:bg-[#0e1b2f] transition-all z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </div>

    <script>
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        const mobDropBtn = document.getElementById('mob-dropdown-btn');
        const mobSub = document.getElementById('mob-sub');
        const mobArrow = document.getElementById('mob-arrow');

        mobDropBtn.addEventListener('click', () => {
            mobSub.classList.toggle('open');
            mobArrow.style.transform = mobSub.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    </script>

    <!-- PAGE CONTENT STARTS BELOW -->
    <main class="flex-grow">