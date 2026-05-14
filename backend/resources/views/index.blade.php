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

    .home-card-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.72) 0%, rgba(0, 0, 0, 0.18) 100%);
    }
</style>

@php
    $resolveImageSrc = function (?string $path, string $fallback = 'images/bla.jpeg'): string {
        $path = (string) $path;

        if ($path === '') {
            return asset($fallback);
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        if (str_starts_with($path, '/storage/') || str_starts_with($path, 'storage/') || str_starts_with($path, 'images/') || str_starts_with($path, 'documents/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $izrabotkiSections = collect($izrabotkiSections ?? []);
    $galleryCards = collect($galleryImages ?? []);
@endphp

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
            {{ __('hero_subtitle') }}
        </div>

        <div class="zanas-tabs absolute top-72 -left-11 px-4 md:px-40 flex flex-wrap justify-center md:justify-between items-center gap-2 md:gap-0 z-10">
            <a href="{{ route('aboutus') }}" class="inline-block px-6 md:px-10 py-3 md:py-4 text-white text-[0.8rem] md:text-[0.9rem] font-bold no-underline rounded-xl transition-all hover:scale-105"
                style="background:rgba(20,55,130,0.85); backdrop-filter:blur(6px);">
                {{ __('about_more') }}
            </a>
        </div>
    </div>


    <!-- ================= ACTIVITIES ================= -->
    <section class="max-w-6xl mx-auto mb-16 mt-12 px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">{{ __('activities') }}</h2>
            <a href="{{ route('activities') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">{{ __('read_more') }}</a>
        </div>

        <div class="overflow-hidden relative">
            <div id="slider" class="flex transition-transform duration-500 gap-6"></div>
        </div>

        <div id="dots" class="flex justify-center mt-6 gap-2"></div>
    </section>


    <!-- ================= E-NEWSPAPER ================= -->
    <section class="max-w-6xl mx-auto px-4 mb-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">{{ __('e_newspaper') }}</h2>
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
                    {{ __('news_and_announcements') }}
                </h2>
                <a href="{{ route('soopstenija') }}" class="w-fit bg-[#2f5fa8] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#244f91] transition">
                    {{ __('read_more') }}
                </a>
            </div>

            <h3 class="text-center text-white text-[20px] md:text-[22px] font-semibold mb-10 md:mb-12">
                {{ __('latest_announcements') }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 md:gap-8 mb-16 md:mb-20">
                @php $latest = $announcements->slice(0, 3); @endphp
                @foreach($latest as $item)
                    <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                        <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                            {{ $item->getTranslation('title', app()->getLocale()) }}
                        </h4>
                        <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                            {{ Str::limit($item->getTranslation('content', app()->getLocale()), 180) }}
                        </p>
                        <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition view-more-btn"
                                data-announcement-title="{{ $item->getTranslation('title', app()->getLocale()) }}"
                                data-announcement-content="{{ $item->getTranslation('content', app()->getLocale()) }}"
                                data-announcement-image="{{ $item->getImageUrl() ?? '' }}">
                            {{ __('view_more') }}
                        </button>
                    </div>
                @endforeach
            </div>

            <h3 class="text-center text-white text-[20px] md:text-[22px] font-semibold mb-10 md:mb-12">
                {{ __('older_announcements') }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 md:gap-8">
                @php $older = $announcements->slice(3, 3); @endphp
                @foreach($older as $item)
                    <div class="min-h-[330px] md:min-h-[360px] flex flex-col bg-white/20 border border-white/30 rounded-xl p-7 md:p-8 backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl">
                        <h4 class="text-white font-bold text-[15px] md:text-[16px] leading-7 underline mb-5">
                            {{ $item->getTranslation('title', app()->getLocale()) }}
                        </h4>
                        <p class="text-white text-[12px] md:text-[13px] leading-6 mb-8">
                            {{ Str::limit($item->getTranslation('content', app()->getLocale()), 140) }}
                        </p>
                        <button class="mt-auto self-start bg-[#0b1a2b] text-white text-[12px] font-semibold px-5 py-2 rounded hover:bg-[#142944] transition view-more-btn"
                                data-announcement-title="{{ $item->getTranslation('title', app()->getLocale()) }}"
                                data-announcement-content="{{ $item->getTranslation('content', app()->getLocale()) }}"
                                data-announcement-image="{{ $item->getImageUrl() ?? '' }}">
                            {{ __('view_more') }}
                        </button>
                    </div>
                @endforeach
            </div>

        </div>
    </div>


    <!-- ================= РАЧНИ ИЗРАБОТКИ + ГАЛЕРИЈА ================= -->
    <div id="rachni-izrabotki-galerija" class="w-full bg-white py-16 md:py-24 px-5 md:px-20">

        <div class="max-w-[1120px] mx-auto mb-20 md:mb-28">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 md:gap-0 mb-12 md:mb-14">
                <h2 class="text-[23px] md:text-[25px] font-bold text-[#0b1a2b]">
                    {{ __('handmade_items') }}
                </h2>

                <a href="{{ route('izrabotki') }}" class="w-fit bg-[#2f5fa8] text-white text-[12px] font-semibold px-6 py-2 rounded-md hover:bg-[#244f91] transition">
                    {{ __('read_more') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7 md:gap-8">
                @forelse ($izrabotkiSections as $index => $section)
                    <a href="{{ route('izrabotki.section', $index) }}" class="relative h-[300px] md:h-[300px] rounded-[18px] overflow-hidden shadow-lg transition-all duration-300 ease-out hover:-translate-y-3 hover:shadow-2xl block group">
                        <img src="{{ $resolveImageSrc($section['main_image'] ?? '', 'images/bla.jpeg') }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $section['title'] ?? '' }}">
                        <div class="absolute inset-0 home-card-overlay"></div>
                        <div class="absolute bottom-0 left-0 w-full min-h-[125px] px-6 py-5 text-white rounded-b-[18px]">
                            <h3 class="text-[16px] font-bold underline mb-4">{{ $section['title'] ?? '' }}</h3>
                            <p class="text-[11px] leading-[20px] text-white">
                                {{ \Illuminate\Support\Str::limit($section['body'] ?? '', 170) }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-1 md:col-span-3 rounded-2xl border border-dashed border-gray-300 p-8 text-center text-gray-500">
                        Нема внесени изработки.
                    </div>
                @endforelse

            </div>

                <!-- MODAL FOR ANNOUNCEMENT DETAILS -->
                <div id="announcementModal" class="modal-overlay">
                    <div class="modal-content">
                        <button class="modal-close" id="closeModal">&times;</button>
                        <div id="modalImage"></div>
                        <h2 class="modal-title" id="modalTitle"></h2>
                        <div class="modal-body" id="modalContent"></div>
                    </div>
                </div>

                <style>
                    .modal-overlay { display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); z-index:1000; overflow-y:auto; padding:20px; }
                    .modal-overlay.active { display:flex; align-items:center; justify-content:center; }
                    .modal-content { background: rgba(255,255,255,0.98); border-radius:15px; max-width:700px; width:100%; padding:30px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); color:#333; max-height:90vh; overflow-y:auto; }
                    .modal-image { width:100%; height:auto; border-radius:10px; margin-bottom:20px; max-height:400px; object-fit:cover; }
                    .modal-title { font-size:24px; font-weight:700; color:#0b1426; margin:15px 0; }
                    .modal-body { font-size:14px; line-height:1.6; color:#333; white-space:pre-wrap; }
                </style>

                <script>
                    (function(){
                        const modal = document.getElementById('announcementModal');
                        const closeBtn = document.getElementById('closeModal');
                        const modalImage = document.getElementById('modalImage');
                        const modalTitle = document.getElementById('modalTitle');
                        const modalContent = document.getElementById('modalContent');
                        const viewMoreBtns = document.querySelectorAll('.view-more-btn');

                        viewMoreBtns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                const title = this.dataset.announcementTitle;
                                const content = this.dataset.announcementContent;
                                const imageUrl = this.dataset.announcementImage;

                                modalTitle.textContent = title || '';
                                modalContent.textContent = content || '';

                                if (imageUrl) {
                                    modalImage.innerHTML = '<img src="' + imageUrl + '" class="modal-image" alt="' + (title || '') + '">';
                                } else {
                                    modalImage.innerHTML = '';
                                }

                                modal.classList.add('active');
                                document.body.style.overflow = 'hidden';
                            });
                        });

                        function closeModalFunc(){
                            modal.classList.remove('active');
                            document.body.style.overflow = 'auto';
                        }

                        if (closeBtn) closeBtn.addEventListener('click', closeModalFunc);
                        modal.addEventListener('click', function(e){ if (e.target === modal) closeModalFunc(); });
                        document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && modal.classList.contains('active')) closeModalFunc(); });
                    })();
                </script>
        </div>

        <div class="max-w-[1120px] mx-auto">

            <h2 class="text-[23px] md:text-[25px] font-bold text-[#0b1a2b] mb-10 md:mb-12">
                {{ __('gallery') }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 md:gap-6 mb-14 md:mb-16">
                @forelse ($galleryImages as $galleryImage)
                    <div class="relative h-[210px] md:h-[205px] rounded-[16px] overflow-hidden shadow-md group">
                        <img src="{{ $galleryImage->resolved_url }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $galleryImage->displayTitle() }}">
                        <div class="absolute inset-0 home-card-overlay"></div>
                        <div class="absolute bottom-0 left-0 w-full min-h-[58px] px-3 py-2 flex items-center justify-center text-white text-[14px] font-bold text-center">
                            {{ $galleryImage->displayTitle() }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-4 rounded-2xl border border-dashed border-gray-300 p-8 text-center text-gray-500">
                        Нема активни галериски слики.
                    </div>
                @endforelse

            </div>

        </div>

    </div>

    <!-- ================= СЕКТОРИ ================= -->
    <div id="sektori" class="w-full bg-white px-5 md:px-6 pt-[150px] md:pt-[220px] pb-[100px] md:pb-[140px]">

        <div class="max-w-[1200px] mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-[95px] md:gap-y-0 md:gap-x-[120px] items-end">

                <div class="flex flex-col items-center">
                    <div class="h-[165px] md:h-[190px] flex items-end justify-center mb-[-15px] relative z-10">
                        <img src="{{ asset('sliki/dokumenti.png') }}" class="h-[155px] md:h-[180px] object-contain drop-shadow-2xl">
                    </div>

                    <div class="w-full max-w-[320px] md:w-[290px] h-[170px] md:h-[175px] bg-[#6f96d8] rounded-[18px] flex flex-col items-center justify-center text-center px-8 md:px-10">
                        <h3 class="text-white text-[15px] md:text-[16px] font-bold mb-[22px]">
                            РЕГУЛАТИВА
                        </h3>

                        <div class="flex flex-col items-center gap-[6px] text-white text-[11px] font-bold underline leading-[16px]">
                            <a href="#">ЗАКОНИ</a>
                            <a href="#">ПРАВИЛНИЦИ</a>
                            <a href="#">УПАТСТВО И ПРОТОКОЛИ</a>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <div class="h-[165px] md:h-[190px] flex items-end justify-center mb-[-15px] relative z-10">
                        <img src="{{ asset('sliki/dokumenti.png') }}" class="h-[155px] md:h-[180px] object-contain drop-shadow-2xl">
                    </div>

                    <div class="w-full max-w-[320px] md:w-[290px] h-[170px] md:h-[175px] bg-[#6f96d8] rounded-[18px] flex flex-col items-center justify-center text-center px-8 md:px-10">
                        <h3 class="text-white text-[15px] md:text-[16px] font-bold mb-[22px]">
                            РЕСУРСИ
                        </h3>

                        <div class="flex flex-col items-center gap-[6px] text-white text-[11px] font-bold underline leading-[16px]">
                            <a href="#">ЈАВНИ НАБАВКИ</a>
                            <a href="#">БУЏЕТ</a>
                            <a href="#">ИЗВЕШТАИ</a>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <div class="h-[165px] md:h-[190px] flex items-end justify-center mb-[-15px] relative z-10">
                        <img src="{{ asset('sliki/dokumenti.png') }}" class="h-[155px] md:h-[180px] object-contain drop-shadow-2xl">
                    </div>

                    <div class="w-full max-w-[320px] md:w-[290px] h-[170px] md:h-[175px] bg-[#6f96d8] rounded-[18px] flex flex-col items-center justify-center text-center px-8 md:px-10">
                        <h3 class="text-white text-[15px] md:text-[16px] font-bold mb-[22px]">
                            ОДНОСИ СО ЈАВНОСТА
                        </h3>

                        <div class="flex flex-col items-center gap-[6px] text-white text-[11px] font-bold underline leading-[16px]">
                            <a href="#">ИНФОРМАЦИИ ОД ЈАВЕН КАРАКТЕР</a>
                            <a href="#">ОГЛАСИ</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-[100px] md:mt-[150px] flex flex-col md:flex-row items-center justify-center gap-5 md:gap-[35px]">

                <a href="#" class="w-full max-w-[340px] md:w-[330px] h-[75px] bg-[#081529] rounded-[6px] flex items-center justify-between px-[20px] text-white text-[14px] md:text-[15px] font-bold hover:opacity-90 transition">
                    <span>Пријави корупција</span>
                    <span>02 25 80 312</span>
                </a>

                <a href="#" class="w-full max-w-[340px] md:w-[330px] h-[75px] bg-[#081529] rounded-[6px] flex items-center px-[20px] text-white text-[14px] md:text-[15px] font-bold leading-[20px] hover:opacity-90 transition">
                    Годишен план за спречување на корупција
                </a>

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

    const activities = {!! json_encode($activities) !!};

    activities.forEach((activity) => {
        const card = document.createElement("div");
        card.className = "activity-card flex-shrink-0 rounded-2xl overflow-hidden relative shadow-lg";
        card.style.transition = "transform 0.35s cubic-bezier(0.25,0.46,0.45,0.94), box-shadow 0.35s ease";
        card.style.cursor = "pointer";
        card.innerHTML = `
    <img src="${activity.image}" class="w-full h-full object-cover">
    <div class="absolute bottom-0 bg-black/60 text-white p-4 w-full">
        <h3 class="font-semibold">${activity.name}</h3>
        <p class="text-xs mt-1">${activity.description}</p>
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
        const hints = ["{{ __('page_hint_next') }}", "{{ __('page_hint_prev') }}"];
        if (el) el.textContent = `${currentPage + 1} / ${pages.length} — ${currentPage < pages.length - 1 ? hints[0] : hints[1]}`;
        if (arrowLeft) arrowLeft.style.opacity = currentPage > 0 ? "1" : "0";
        if (arrowRight) arrowRight.style.opacity = currentPage < pages.length - 1 ? "1" : "0";
    }
    updatePageIndicator();
</script>

@endsection
