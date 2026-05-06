@extends('layouts.app')

@section('title', 'Идризово - Дома')

@section('content')
<style>
    .zanas-tabs a {
        transition: background 0.2s, opacity 0.2s;
    }

    .zanas-tabs a.active {
        background: rgba(46, 88, 158, 0.95) !important;
        box-shadow: 0 0 0 2px rgba(100, 181, 246, 0.5);
    }

    .zanas-tabs a:hover {
        opacity: 0.85;
    }

    .section-sektori::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to bottom, #ffffff 0%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }

    .section-sektori::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to top, #ffffff 0%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }

    .perspective {
        perspective: 1500px;
    }
</style>

<div class="font-sans text-[#1a2a4a] bg-white overflow-x-hidden">

    <!-- ================= HERO ================= -->
    <div class="relative w-full overflow-hidden bg-[#1a3a6b] h-[520px] md:h-[820px]">
        <img class="absolute inset-0 w-full h-full object-cover object-center"
            src="{{ asset('images/hero_main.jpeg') }}" alt="За Нас">
        <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(10,30,70,0.3) 0%, rgba(10,30,70,0.6) 100%);"></div>

        <div class="absolute top-20 left-6 md:left-28 text-black text-4xl md:text-7xl font-bold tracking-widest uppercase z-10" style="text-shadow:0 2px 8px rgba(0,0,0,0.4);">
            КПУ
        </div>
        <div class="absolute top-40 left-6 md:left-28 text-black text-4xl md:text-7xl font-bold tracking-widest uppercase z-10" style="text-shadow:0 2px 8px rgba(0,0,0,0.4);">
            ИДРИЗОВО
        </div>
        <div class="absolute top-[18rem] md:top-[22rem] left-6 md:left-28 text-white text-sm md:text-xl font-semibold tracking-widest uppercase z-10" style="text-shadow:0 2px 8px rgba(0,0,0,0.6);">
            со отворено одделение Велес
        </div>

        <div class="zanas-tabs absolute top-72 -left-11 px-4 md:px-40 flex flex-wrap justify-center md:justify-between items-center gap-2 md:gap-0 z-10">
            <a href="{{ route('aboutus') }}" class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105"
                style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);">
                Повеќе за нас
            </a>
        </div>
    </div>


    <!-- ================= ACTIVITIES ================= -->
    <section class="max-w-6xl mx-auto mb-16 mt-12 px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Активности</h2>
            <a href="{{ route('activities') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">Прочитај повеќе</a>
        </div>

        <div class="overflow-hidden relative">
            <div id="slider" class="flex transition-transform duration-500 gap-6"></div>
        </div>

        <div id="dots" class="flex justify-center mt-6 gap-2"></div>
    </section>


    <!-- ================= E-NEWSPAPER ================= -->
    <section class="max-w-6xl mx-auto px-4 mb-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Е-весник</h2>
        </div>

        <div class="flex flex-col items-center gap-4">
            <span id="pageIndicator" class="text-sm text-gray-500 font-medium mb-1">1 / 2 — Кликни за да превртиш</span>

            <div id="book"
                class="relative w-full max-w-[900px] h-[600px] md:h-[820px] perspective cursor-pointer select-none"
                title="Кликни за да превртиш страница">

                <div id="pages" class="relative w-full h-full">
                    <img src="{{ asset('images/vesnik.png') }}"
                        class="page absolute w-full h-full object-contain rounded-xl shadow-2xl">
                    <img src="{{ asset('images/vesnik2.png') }}"
                        class="page absolute w-full h-full object-contain rounded-xl shadow-2xl">
                </div>

                <div class="absolute inset-0 flex items-center justify-between px-4 pointer-events-none">
                    <div id="arrowLeft" class="bg-black/30 text-white rounded-full w-10 h-10 flex items-center justify-center text-xl opacity-0 transition-opacity duration-300">‹</div>
                    <div id="arrowRight" class="bg-black/30 text-white rounded-full w-10 h-10 flex items-center justify-center text-xl opacity-0 transition-opacity duration-300">›</div>
                </div>
            </div>
        </div>
    </section>


    <!-- ================= NOVOSTI ================= -->
    <div id="novosti" class="w-full flex justify-center px-5 md:px-6 py-16 md:py-24 bg-[linear-gradient(to_bottom,#ffffff_0%,#dbe6f5_12%,#9fb7dc_22%,#6f8fc2_30%,#6f8fc2_75%,#9fb7dc_85%,#dbe6f5_92%,#ffffff_100%)]">
        <div class="w-full max-w-[1120px]">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 md:gap-0 mb-14 md:mb-20">
                <h2 class="text-[22px] md:text-[24px] font-bold text-[#0b1a2b]">
                    Новости и соопштенија
                </h2>
                <a href="{{ route('soopstenija') }}" class="w-fit bg-[#2f5fa8] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#244f91] transition">
                    Прочитај повеќе
                </a>
            </div>

            <h3 class="text-center text-white text-[20px] md:text-[22px] font-semibold mb-10 md:mb-12">
                Нови соопштенија
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 md:gap-8 mb-16 md:mb-20">
                <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                        ИНТЕРЕН ОГЛАС за пополнување на работно место со унапредување на административен службеник
                    </h4>
                    <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                        Врз основа на член 30 став 1 алинеја 2 став 3 и став 5, член 48 и член 49 од Законот за административни службеници...
                    </p>
                    <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition">
                        Види повеќе
                    </button>
                </div>

                <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                        Одлука за избор на кандидати за унапредување на административни службеници
                    </h4>
                    <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                        Врз основа на член 52 став 1 од Законот за административни службеници...
                    </p>
                    <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition">
                        Види повеќе
                    </button>
                </div>

                <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                        Предлог на одлука за избор на кандидати за унапредување на административни службеници
                    </h4>
                    <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                        Врз основа на член 52 став 1 од Законот за административни службеници...
                    </p>
                    <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition">
                        Види повеќе
                    </button>
                </div>
            </div>

            <h3 class="text-center text-white text-[20px] md:text-[22px] font-semibold mb-10 md:mb-12">
                Постари соопштенија
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 md:gap-8">
                <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                        ИНТЕРЕН ОГЛАС за пополнување на работни места со унапредување на административни службеници
                    </h4>
                    <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                        Врз основа на член 30 став 1 алинеја 2 став 3 и став 5...
                    </p>
                    <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition">
                        Види повеќе
                    </button>
                </div>

                <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                        ИНТЕРЕН ОГЛАС за пополнување на работни места со унапредување на припадници на затворска полиција
                    </h4>
                    <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                        Врз основа на член 67 став 1 алинеја 2...
                    </p>
                    <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition">
                        Види повеќе
                    </button>
                </div>

                <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                        Рок за поднесување пријави по Јавниот оглас за вработување...
                    </h4>
                    <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                        Пријавите заедно со документите...
                    </p>
                    <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition">
                        Види повеќе
                    </button>
                </div>
            </div>

        </div>
    </div>


    <!-- ================= РАЧНИ ИЗРАБОТКИ + ГАЛЕРИЈА ================= -->
    <div id="rachni-izrabotki-galerija" class="w-full bg-white py-16 md:py-24 px-5 md:px-20">

        <div class="max-w-[1120px] mx-auto mb-20 md:mb-28">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 md:gap-0 mb-12 md:mb-14">
                <h2 class="text-[23px] md:text-[25px] font-bold text-[#0b1a2b]">
                    Рачни изработки
                </h2>

                <a href="{{ route('izrabotki') }}" class="w-fit bg-[#2f5fa8] text-white text-[12px] font-semibold px-6 py-2 rounded-md hover:bg-[#244f91] transition">
                    Прочитај повеќе
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 md:gap-8">

                <div class="relative h-[300px] md:h-[300px] rounded-[18px] overflow-hidden shadow-lg transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full min-h-[125px] px-6 py-5 bg-black/35 backdrop-blur-sm text-white rounded-b-[18px]">
                        <h3 class="text-[16px] font-bold underline mb-4">Lorem Ipsum</h3>
                        <p class="text-[11px] leading-[20px] text-white">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the
                        </p>
                    </div>
                </div>

                <div class="relative h-[300px] md:h-[300px] rounded-[18px] overflow-hidden shadow-lg transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full min-h-[125px] px-6 py-5 bg-black/35 backdrop-blur-sm text-white rounded-b-[18px]">
                        <h3 class="text-[16px] font-bold underline mb-4">Lorem Ipsum</h3>
                        <p class="text-[11px] leading-[20px] text-white">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the
                        </p>
                    </div>
                </div>

                <div class="relative h-[300px] md:h-[300px] rounded-[18px] overflow-hidden shadow-lg transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full min-h-[125px] px-6 py-5 bg-black/35 backdrop-blur-sm text-white rounded-b-[18px]">
                        <h3 class="text-[16px] font-bold underline mb-4">Lorem Ipsum</h3>
                        <p class="text-[11px] leading-[20px] text-white">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="max-w-[1120px] mx-auto">

            <h2 class="text-[23px] md:text-[25px] font-bold text-[#0b1a2b] mb-10 md:mb-12">
                Галерија
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 md:gap-6 mb-14 md:mb-16">

                <div class="relative h-[210px] md:h-[205px] rounded-[16px] overflow-hidden shadow-md">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full h-[58px] flex items-center justify-center bg-black/45 backdrop-blur-sm text-white text-[14px] font-bold">
                        РАЧНИ ИЗРАБОТКИ
                    </div>
                </div>

                <div class="relative h-[210px] md:h-[205px] rounded-[16px] overflow-hidden shadow-md">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full h-[58px] flex items-center justify-center bg-black/45 backdrop-blur-sm text-white text-[14px] font-bold">
                        АКТИВНОСТИ
                    </div>
                </div>

                <div class="relative h-[210px] md:h-[205px] rounded-[16px] overflow-hidden shadow-md">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full h-[58px] flex items-center justify-center bg-black/45 backdrop-blur-sm text-white text-[14px] font-bold">
                        НАСТАНИ
                    </div>
                </div>

                <div class="relative h-[210px] md:h-[205px] rounded-[16px] overflow-hidden shadow-md">
                    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full h-[58px] flex items-center justify-center bg-black/45 backdrop-blur-sm text-white text-[14px] font-bold">
                        УСТАНОВА
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
    // ================= ACTIVITIES LOGIC =================
    const slider = document.getElementById("slider");
    const dotsContainer = document.getElementById("dots");

    let currentIndex = 0;
    const VISIBLE = 3;

    const activities = [
        "Натпревар во шах", "Заварување", "Резба", "Столарија",
        "Електрика", "Везење", "Цртање", "Шиење", "Сликање", "Спорт"
    ];

    activities.forEach((name) => {
        const card = document.createElement("div");
        card.className = "activity-card flex-shrink-0 rounded-2xl overflow-hidden relative shadow-lg";
        card.style.transition = "transform 0.35s cubic-bezier(0.25,0.46,0.45,0.94), box-shadow 0.35s ease";
        card.style.cursor = "pointer";
        card.innerHTML = `
    <img src="{{ asset('images/bla.jpeg') }}" class="w-full h-full object-cover">
    <div class="absolute bottom-0 bg-black/60 text-white p-4 w-full">
        <h3 class="font-semibold">${name}</h3>
        <p class="text-xs mt-1">Опис на активност...</p>
    </div>
`;
        card.addEventListener("mouseenter", () => {
            card.style.transform = "translateY(-18px) scale(1.03)";
            card.style.boxShadow = "0 24px 48px rgba(0,0,0,0.25)";
        });
        card.addEventListener("mouseleave", () => {
            card.style.transform = "translateY(0) scale(1)";
            card.style.boxShadow = "";
        });
        slider.appendChild(card);
    });

    const totalPages = Math.ceil(activities.length / VISIBLE);

    function sizeCards() {
        const containerW = slider.parentElement.offsetWidth;
        const gap = 24;
        const cardW = (containerW - gap * (VISIBLE - 1)) / VISIBLE;
        document.querySelectorAll(".activity-card").forEach(c => {
            c.style.width = cardW + "px";
            c.style.height = "340px";
        });
        slider.style.gap = gap + "px";
        updateSlider();
    }

    for (let i = 0; i < totalPages; i++) {
        const dot = document.createElement("div");
        dot.className = "w-3 h-3 bg-gray-300 rounded-full transition-all duration-300 cursor-pointer";
        dot.addEventListener("click", () => {
            currentIndex = i;
            updateSlider();
        });
        dotsContainer.appendChild(dot);
    }

    function updateSlider() {
        const containerW = slider.parentElement.offsetWidth;
        slider.style.transform = `translateX(-${currentIndex * (containerW + 24)}px)`;
        [...dotsContainer.children].forEach((dot, i) => {
            dot.className = i === currentIndex ?
                "h-3 w-8 bg-black rounded-full transition-all duration-300 cursor-pointer" :
                "w-3 h-3 bg-gray-300 rounded-full transition-all duration-300 cursor-pointer";
        });
    }

    window.addEventListener("resize", sizeCards);
    setTimeout(sizeCards, 0);


    // ================= NEWSPAPER FLIP =================
    const pages = document.querySelectorAll(".page");
    const arrowLeft = document.getElementById("arrowLeft");
    const arrowRight = document.getElementById("arrowRight");
    const book = document.getElementById("book");
    let currentPage = 0;

    pages.forEach((page, i) => {
        page.style.zIndex = pages.length - i;
        page.style.transformOrigin = "left center";
        page.style.transition = "transform 0.8s cubic-bezier(0.4,0,0.2,1)";
        page.style.backfaceVisibility = "hidden";
        page.style.transform = "rotateY(0deg)";
    });

    function goNext() {
        if (currentPage < pages.length - 1) {
            pages[currentPage].style.transform = "rotateY(-180deg)";
            pages[currentPage].style.zIndex = currentPage;
            currentPage++;
            updatePageIndicator();
        }
    }

    function goPrev() {
        if (currentPage > 0) {
            currentPage--;
            pages[currentPage].style.transform = "rotateY(0deg)";
            pages[currentPage].style.zIndex = pages.length - currentPage;
            updatePageIndicator();
        }
    }

    book.addEventListener("click", (e) => {
        const rect = book.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        clickX < rect.width / 2 ? goPrev() : goNext();
    });

    book.addEventListener("mouseenter", () => {
        arrowLeft.style.opacity = currentPage > 0 ? "1" : "0";
        arrowRight.style.opacity = currentPage < pages.length - 1 ? "1" : "0";
    });
    book.addEventListener("mousemove", (e) => {
        const rect = book.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        arrowLeft.style.opacity = (clickX < rect.width / 2 && currentPage > 0) ? "1" : "0";
        arrowRight.style.opacity = (clickX >= rect.width / 2 && currentPage < pages.length - 1) ? "1" : "0";
    });
    book.addEventListener("mouseleave", () => {
        arrowLeft.style.opacity = "0";
        arrowRight.style.opacity = "0";
    });

    function updatePageIndicator() {
        const el = document.getElementById("pageIndicator");
        const hints = ["Кликни десно за следна", "Кликни лево за назад"];
        if (el) el.textContent = `${currentPage + 1} / ${pages.length} — ${currentPage < pages.length - 1 ? hints[0] : hints[1]}`;
        if (arrowLeft) arrowLeft.style.opacity = currentPage > 0 ? "1" : "0";
        if (arrowRight) arrowRight.style.opacity = currentPage < pages.length - 1 ? "1" : "0";
    }
    updatePageIndicator();
</script>

@endsection
