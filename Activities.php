<?php require_once __DIR__ . '/header.php'; ?>
<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Активности - Целосен Дизајн</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS за сокривање на скролбарот, но задржување на функционалноста (за мобилен) */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
    </style>
</head>
<body class="bg-white font-sans antialiased">

    <section class="relative w-full min-h-[600px] h-screen bg-cover bg-center bg-no-repeat" 
             style="background-image: url('https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=1920&auto=format&fit=crop');">
        
        <div class="absolute inset-0 bg-white/20"></div>

        <div class="absolute top-1/3 left-8 md:left-24 max-w-md z-10">
            <h3 class="text-white font-semibold text-xl mb-2 drop-shadow-md">
                Најнова активност
            </h3>
            
            <h1 class="text-[#0E1B2F] text-6xl md:text-7xl font-extrabold mb-4 tracking-tight drop-shadow-sm">
                Кошарка
            </h1>
            
            <p class="text-[#0E1B2F] text-base md:text-lg mb-8 font-semibold leading-snug pr-4 drop-shadow-md">
                Кошарка за подобрување на физичкото здравје, тимската работа и позитивниот ангажман.
            </p>
            
            <button class="bg-[#2E589E] hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-md shadow-lg transition-all duration-300 transform hover:scale-105">
                Прочитај повеќе
            </button>
        </div>
    </section>

    <button class="fixed bottom-8 right-8 bg-[#2E589E] hover:bg-blue-700 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-2xl transition-all duration-300 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>


    <section class="md:hidden max-w-md mx-auto py-12">
        <div class="flex justify-between items-center px-5 mb-6">
            <h2 class="text-[#0E1B2F] text-2xl font-extrabold tracking-tight">Активности</h2>
            <a href="#" class="bg-[#2E589E] hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors shadow-sm">
                Сите активности
            </a>
        </div>

        <div id="mobile-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-4 px-5 pb-6 hide-scrollbar">
            
            <div class="carousel-item snap-center shrink-0 w-[82vw] h-[400px] relative rounded-2xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1580541832626-2a7131ee809f?q=80&w=600&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner">
                    <h2 class="text-2xl font-bold text-white mb-2 inline-block border-b-2 border-white pb-1">Шах</h2>
                    <p class="text-white/90 text-sm leading-snug">Шаховски натпревар што поттикнува фокус, стратешко размислување.</p>
                </div>
            </div>

            <div class="carousel-item snap-center shrink-0 w-[82vw] h-[400px] relative rounded-2xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?q=80&w=600&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner">
                    <h2 class="text-2xl font-bold text-white mb-2 inline-block border-b-2 border-white pb-1">Заварување</h2>
                    <p class="text-white/90 text-sm leading-snug">Активности каде учениците учат безбедно да спојуваат метал.</p>
                </div>
            </div>

            <div class="carousel-item snap-center shrink-0 w-[82vw] h-[400px] relative rounded-2xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1622322366835-ce065e886915?q=80&w=600&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner">
                    <h2 class="text-2xl font-bold text-white mb-2 inline-block border-b-2 border-white pb-1">Столарија</h2>
                    <p class="text-white/90 text-sm leading-snug">Занает на работа со дрво за создавање конструирање.</p>
                </div>
            </div>

            <div class="carousel-item snap-center shrink-0 w-[82vw] h-[400px] relative rounded-2xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=600&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 w-full p-6 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner">
                    <h2 class="text-2xl font-bold text-white mb-2 inline-block border-b-2 border-white pb-1">Спорт</h2>
                    <p class="text-white/90 text-sm leading-snug">Физички вежби за градење сила, кондиција и благосостојба.</p>
                </div>
            </div>

        </div>

        <div class="flex justify-center items-center gap-3 mt-2" id="carousel-indicators">
            <div class="carousel-dot w-10 h-3.5 bg-[#0E1B2F] rounded-full transition-all duration-300"></div>
            <div class="carousel-dot w-3.5 h-3.5 rounded-full border-[2px] border-[#0E1B2F] transition-all duration-300"></div>
            <div class="carousel-dot w-3.5 h-3.5 rounded-full border-[2px] border-[#0E1B2F] transition-all duration-300"></div>
            <div class="carousel-dot w-3.5 h-3.5 rounded-full border-[2px] border-[#0E1B2F] transition-all duration-300"></div>
        </div>
    </section>


    <section class="hidden md:block max-w-7xl mx-auto px-4 py-16 font-sans">
        <div class="mb-16">
            <h2 class="text-[#1a2b4b] text-3xl font-bold mb-8">Најчитани активности</h2>
            <div class="grid grid-cols-4 gap-6">
                <div class="col-span-2 row-span-2 relative h-[508px] rounded-2xl overflow-hidden group shadow-lg">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1580541832626-2a7131ee809f?q=80&w=800&auto=format&fit=crop');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-8 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h3 class="text-3xl font-bold mb-3">Натпревар во шах</h3>
                        <p class="text-base opacity-90 mb-5">Шаховски натпревар што поттикнува фокус, стратешко размислување и позитивна интеракција.</p>
                        <a href="#" class="text-sm uppercase tracking-wider font-bold border-b-2 border-white pb-1">Прочитај повеќе</a>
                    </div>
                </div>

                <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h4 class="font-bold text-xl mb-1">Заварување</h4>
                        <p class="text-xs leading-tight opacity-90 mb-3">Активности за заварување каде учениците учат безбедно да спојуваат метал.</p>
                        <a href="#" class="text-[11px] uppercase font-bold border-b border-white">Прочитај повеќе</a>
                    </div>
                </div>

                <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h4 class="font-bold text-xl mb-1">Резба</h4>
                        <p class="text-xs leading-tight opacity-90 mb-3">Рачно изработени резби создадени со грижа и вештина.</p>
                        <a href="#" class="text-[11px] uppercase font-bold border-b border-white">Прочитај повеќе</a>
                    </div>
                </div>

                <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1622322366835-ce065e886915?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h4 class="font-bold text-xl mb-1">Столарија</h4>
                        <p class="text-xs leading-tight opacity-90 mb-3">Занает на работа со дрво за создавање конструирање.</p>
                        <a href="#" class="text-[11px] uppercase font-bold border-b border-white">Прочитај повеќе</a>
                    </div>
                </div>

                <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h4 class="font-bold text-xl mb-1">Електрика</h4>
                        <p class="text-xs leading-tight opacity-90 mb-3">Учење и извршување електрични задачи.</p>
                        <a href="#" class="text-[11px] uppercase font-bold border-b border-white">Прочитај повеќе</a>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-[#1a2b4b] text-3xl font-bold mb-8">Останати активности</h2>
            <div class="grid grid-cols-4 gap-6">
                <div class="grid grid-cols-2 col-span-2 gap-6">
                    <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1584992236310-6edddc08acff?q=80&w=600&auto=format&fit=crop');"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                            <h4 class="font-bold text-lg mb-2">Везење</h4>
                            <a href="#" class="text-xs uppercase border-b border-white">Прочитај повеќе</a>
                        </div>
                    </div>
                    <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=600&auto=format&fit=crop');"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                            <h4 class="font-bold text-lg mb-2">Цртање</h4>
                            <a href="#" class="text-xs uppercase border-b border-white">Прочитај повеќе</a>
                        </div>
                    </div>
                    <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1605371801869-2f22b7a2dce7?q=80&w=600&auto=format&fit=crop');"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                            <h4 class="font-bold text-lg mb-2">Шиење</h4>
                            <a href="#" class="text-xs uppercase border-b border-white">Прочитај повеќе</a>
                        </div>
                    </div>
                    <div class="relative h-[242px] rounded-2xl overflow-hidden group shadow-md">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?q=80&w=600&auto=format&fit=crop');"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                            <h4 class="font-bold text-lg mb-2">Сликање</h4>
                            <a href="#" class="text-xs uppercase border-b border-white">Прочитај повеќе</a>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 relative h-[508px] rounded-2xl overflow-hidden group shadow-lg">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800&auto=format&fit=crop');"></div>
                    <div class="absolute bottom-0 left-0 w-full p-8 bg-white/5 backdrop-blur-md rounded-t-2xl border border-white/10 shadow-inner text-white">
                        <h3 class="text-3xl font-bold mb-3">Спорт</h3>
                        <p class="text-base opacity-90 mb-5">Физички вежби за градење сила, кондиција и целокупна благосостојба.</p>
                        <a href="#" class="text-sm uppercase tracking-wider font-bold border-b-2 border-white pb-1">Прочитај повеќе</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carouselItems = document.querySelectorAll('.carousel-item');
            const dots = document.querySelectorAll('.carousel-dot');

            // Опции: кога најмалку 50% од сликата е видлива, се смета за "активна"
            const observerOptions = {
                root: document.getElementById('mobile-carousel'),
                threshold: 0.5 
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Наоѓање кој индекс е моментално видливиот
                        const index = Array.from(carouselItems).indexOf(entry.target);
                        
                        // Ажурирање на стиловите на точките
                        dots.forEach((dot, i) => {
                            if (i === index) {
                                // Активна точка (капсула)
                                dot.className = 'carousel-dot w-10 h-3.5 bg-[#0E1B2F] rounded-full transition-all duration-300';
                            } else {
                                // Неактивна точка (празно кругче)
                                dot.className = 'carousel-dot w-3.5 h-3.5 bg-transparent rounded-full border-[2px] border-[#0E1B2F] transition-all duration-300';
                            }
                        });
                    }
                });
            }, observerOptions);

            // Поставување на обсерверот за секоја слика во мобилниот скрол
            carouselItems.forEach(item => observer.observe(item));
        });
    </script>

</body>
</html>
<?php require_once __DIR__ . '/footer.php'; ?>