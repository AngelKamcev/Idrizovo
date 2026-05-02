<?php require_once __DIR__ . '/header.php'; ?>
<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакт - Идризово</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans text-[#0a192f] antialiased">

    <section class="relative min-h-screen">
        <div class="h-24 bg-white"></div>
        
        <div class="bg-gradient-to-b from-white via-[#6A92D4] via-[#2E589E] to-white py-16 px-6 md:px-20">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 lg:gap-16 relative z-10">
                
                <div class="w-full lg:w-1/2">
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight text-[#0a192f]">Контакт</h2>
                    <p class="text-white text-base mb-10 leading-relaxed max-w-lg opacity-95">
                        Доколку имате прашања, потреба од дополнителни информации или сакате да закажете официјална посета, нашиот тим е тука за вас.
                    </p>

                    <div class="space-y-4 mb-12">
                        <div class="bg-white/95 p-3 rounded-xl shadow-sm flex items-center max-w-md">
                            <div class=" p-2 rounded-lg mr-4 ml-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#0a192f]">Телефонски број: 02 25 80 312</span>
                        </div>
                        <div class="bg-white/95 p-3 rounded-xl shadow-sm flex items-center max-w-md">
                            <div class=" p-2 rounded-lg mr-4 ml-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#0a192f]">Email: Kpuidrizovo@Kpuidrizovo.Gov.Mk</span>
                        </div>
                        <div class="bg-white/95 p-3 rounded-xl shadow-sm flex items-center max-w-md">
                            <div class=" p-2 rounded-lg mr-4 ml-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#0a192f]">Ул.1 Колонија Идризово бр. 4А</span>
                        </div>
                    </div>

                    <div class="bg-white/95 p-3 rounded-xl shadow-sm max-w-md text-center hidden md:block">
                        <h4 class="font-black text-[#2E589E] text-sm uppercase mb-4 tracking-widest">Работно време</h4>
                        <div class="space-y-2 text-[11px] text-gray-600 font-bold uppercase">
                            
                            <p class="">Lorem Ipsum</p>
                             <p class="">Lorem Ipsum</p>
                              <p class="">Lorem Ipsum</p>
                               <p class="">Lorem Ipsum</p>
                                <p class="">Lorem Ipsum</p>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-[500px] bg-white p-8 md:p-12 rounded-[40px] shadow-2xl self-start">
                    <h3 class="text-2xl font-black text-center mb-8 text-[#0a192f]">Испрати порака</h3>
                    <form class="space-y-4">
                        <input type="text" placeholder="Име и презиме" class="w-full p-4 bg-gray-50 border border-black rounded-xl text-sm outline-none">
                        <input type="text" placeholder="Телефонски број" class="w-full p-4 bg-gray-50 border border-black rounded-xl text-sm outline-none">
                        <input type="email" placeholder="Email" class="w-full p-4 bg-gray-50 border border-black rounded-xl text-sm outline-none">
                        <input type="text" placeholder="Family Relationship(семејна врска)" class="w-full p-4 bg-gray-50 border border-black rounded-xl text-sm outline-none">
                        <textarea rows="5" placeholder="Остави порака" class="w-full p-4 bg-gray-50 border border-black rounded-xl text-sm outline-none resize-none"></textarea>
                        <div class="flex justify-center pt-4">
                            <button class="bg-[#0b1b36] hover:bg-[#2E589E] text-white w-full py-4 rounded-xl font-black text-sm uppercase tracking-widest transition-all shadow-lg active:scale-95">Испрати</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="h-24 bg-white"></div>
    </section>

    <section class="py-16 px-6 bg-white">
        <h2 class="text-3xl md:text-4xl font-black text-center mb-16 text-[#0a192f]">Закажи посета</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6">
            
            <div class="bg-[#6A92D4] p-10 rounded-[40px] text-white text-center shadow-xl transform transition hover:scale-105">
                <h3 class="text-2xl font-black mb-8">Преку телефон</h3>
                <p class="text-[13px] font-medium mb-6">Понеделник-Четврток</p>
                <div class="flex justify-center gap-6 text-[11px] mb-8">
                    <div>Прва смена<br><span class="font-bold opacity-80">08:30-10:30</span></div>
                    <div>Втора смена<br><span class="font-bold opacity-80">14:00-18:00</span></div>
                </div>
                <p class="text-[13px] font-medium mb-2">Петок</p>
                <p class="text-[11px] font-bold opacity-80 mb-10">8:30-18:00</p>
                <button class="bg-[#0E1B2F] w-full py-3 rounded-xl font-bold text-sm tracking-wide">02 25 80365</button>
            </div>
            
            <div class="bg-[#6A92D4] p-10 rounded-[40px] text-white text-center shadow-xl transform transition hover:scale-105">
                <h3 class="text-2xl font-black mb-10">Закажи Online</h3>
                <p class="text-[13px] leading-relaxed mb-12 px-2 font-medium">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                </p>
                <button class="bg-[#0E1B2F] w-full py-3 rounded-xl font-bold text-sm mt-12 tracking-wide">Кликни за календар</button>
            </div>

            <div class="bg-[#6A92D4] p-10 rounded-[40px] text-white text-center shadow-xl transform transition hover:scale-105">
                <h3 class="text-2xl font-black mb-8">Преку портирница</h3>
                <p class="text-[13px] font-medium mb-2">Понеделник - Четврток</p>
                <p class="text-[11px] font-bold opacity-80 mb-8 italic">13:00-14:00 часот</p>
                <p class="text-[13px] font-medium mb-6">Сабота и недела</p>
                <div class="space-y-2 text-[11px] font-bold opacity-80 mb-10 text-center">
                    <p>1 Група: 08:30-09:30</p>
                    <p>2 Група: 10:30-11:30</p>
                    <p>3 Група: 12:30-13:30</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 md:px-10 text-center">
            <h2 class="text-3xl font-black mb-12 text-[#0a192f]">ЛОКАЦИЈА</h2>
            <div class="relative w-full h-[400px] md:h-[600px] overflow-hidden shadow-2xl  ">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4892.498505968168!2d21.56066529112234!3d41.958328304165825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13543f300cf6f5ab%3A0xc775d2423b8cd12c!2sPP%20Skopje%20-%20Idrizovo%20Prison!5e0!3m2!1sen!2smk!4v1777561269925!5m2!1sen!2smk" width="1800" height="800" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                    
                </div>
            </div>
        </div>
    </section>

    <!-- <button class="fixed bottom-8 right-8 bg-[#2E589E] hover:bg-[#0b1b36] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl transition-all z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button> -->

</body>
</html>
<?php require_once __DIR__ . '/footer.php'; ?>