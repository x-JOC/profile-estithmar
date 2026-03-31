<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>استثمار المستقبل | واجهة تفاعلية</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback if Vite is not running -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#005358',
                            secondary: '#ceaf87',
                            accent: '#8b9d90',
                            danger: '#e8493c',
                            success: '#00b48d',
                            sub: '#149b9e'
                        },
                        fontFamily: {
                            rawasi: ['Rawasi', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <style>
            @font-face {
                font-family: 'Rawasi';
                src: url('/font/itfRawasiDisplayARLT-Regular.otf') format('opentype');
                font-weight: 400;
            }
            @font-face {
                font-family: 'Rawasi';
                src: url('/font/itfRawasiDisplayARLT-Bold.otf') format('opentype');
                font-weight: 700;
            }
            body { font-family: 'Rawasi', sans-serif; }
        </style>
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        /* Smooth scrolling inside containers if needed */
        .touch-scroll { -webkit-overflow-scrolling: touch; }
        
        /* Disable text selection for kiosk app */
        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.5); 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #8b9d90; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #005358; 
        }

        /* Glassmorphism helpers */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }
        
        /* Animated floating blobs */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 15s infinite alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* 3D Book Styles */
        .book-container {
            perspective: 1000px;
        }
        .book {
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.5s;
            box-shadow: -10px 10px 20px rgba(0,0,0,0.15);
            width: 160px;
            height: 240px;
        }
        .book-container:hover .book {
            transform: rotateY(-20deg) rotateX(5deg);
        }
        .book-front {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #005358;
            border-radius: 2px 10px 10px 2px;
            transform: translateZ(12px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.5rem;
            color: white;
            z-index: 2;
            overflow: hidden;
            border-left: 2px solid rgba(255,255,255,0.2);
        }
        .book-front::before {
            content: '';
            position: absolute;
            top: 0;
            left: 5%;
            width: 3%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0.1), rgba(0,0,0,0.2), rgba(255,255,255,0.1));
            z-index: 10;
        }
        .book-spine {
            position: absolute;
            top: 0;
            left: 0;
            width: 24px;
            height: 100%;
            background-color: #004145;
            transform: rotateY(-90deg) translateZ(12px);
            transform-origin: left center;
            border-radius: 2px 0 0 2px;
        }
        .book-back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #004145;
            transform: rotateY(180deg) translateZ(12px);
            border-radius: 10px 2px 2px 10px;
        }
        .book-pages {
            position: absolute;
            top: 2%;
            right: 0;
            width: 24px;
            height: 96%;
            background: linear-gradient(to right, #f3f4f6, #e5e7eb, #d1d5db);
            transform: rotateY(90deg) translateZ(calc(160px - 12px));
            transform-origin: right center;
            z-index: 1;
            border-radius: 2px;
        }
        .book-pages-top {
            position: absolute;
            top: 0;
            left: 2%;
            width: 96%;
            height: 24px;
            background: #e5e7eb;
            transform: rotateX(90deg) translateZ(12px);
            transform-origin: top center;
        }
        .book-pages-bottom {
            position: absolute;
            bottom: 0;
            left: 2%;
            width: 96%;
            height: 24px;
            background: #d1d5db;
            transform: rotateX(-90deg) translateZ(12px);
            transform-origin: bottom center;
        }
        
    </style>
</head>
<body class="bg-[#f0f4f2] text-black overflow-hidden relative"
      x-data="exhibition()"
      @touchstart.window="resetTimer()"
      @click.window="resetTimer()">

    <!-- Premium Background (Modern & Animated) -->
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-[#f8faf9] via-[#f0f4f2] to-[#e8eee9]"></div>
    <div class="fixed inset-0 z-0 opacity-[0.04] mix-blend-color-burn pointer-events-none" 
         style="background-image: url('{{ asset('images/patterns.svg') }}'); background-repeat: repeat; background-size: 250px;"></div>

    <!-- Animated Glow Orbs for visual excellence -->
    <div class="fixed top-[-10%] left-[-10%] w-[60%] h-[60%] bg-primary/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob pointer-events-none z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[60%] h-[60%] bg-secondary/20 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000 pointer-events-none z-0"></div>
    <div class="fixed top-[40%] left-[30%] w-[40%] h-[40%] bg-sub/10 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-4000 pointer-events-none z-0"></div>

    <!-- Floating Home Button -->
    <button x-show="screen !== 1" x-cloak
            @click="goTo(1)"
            x-transition
            class="fixed top-8 right-8 z-50 bg-white/80 backdrop-blur-md shadow-[0_10px_25px_rgba(0,0,0,0.05)] border border-white rounded-full w-14 h-14 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:border-transparent hover:shadow-[0_10px_25px_rgba(0,83,88,0.3)] transition-all transform active:scale-95 duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
    </button>

    <!-- Main Screens Container -->
    <div class="relative z-10 w-full h-screen">

        <!-- SCREEN 1: Introduction -->
        <div x-show="screen === 1" x-cloak
             x-transition:enter="transition duration-1000 ease-out delay-100" 
             x-transition:enter-start="opacity-0 translate-y-8" 
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition duration-500 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center pointer-events-auto h-full">
            
            <div class="flex-col items-center w-full max-w-4xl mx-auto flex h-full justify-center">
                
                <!-- Logos Area (Glassmorphism layout) -->
                <div class="mb-12 flex flex-col items-center">
                    <img src="{{ asset('images/logo.svg') }}" alt="استثمار المستقبل القابضة" class="w-72 lg:w-80 mb-10 drop-shadow-md">
                    
                    <div class="inline-flex items-center justify-center gap-3 md:gap-6 glass-panel px-6 md:px-8 py-4 rounded-2xl relative overflow-hidden mx-auto shadow-sm">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent animate-[shimmer_3s_infinite] -translate-x-[200%]"></div>
                        <img src="{{ asset('images/faradah.svg') }}" alt="فرادة" class="h-7 md:h-9">
                        <div class="w-px h-8 md:h-10 bg-gray-300/50"></div>
                        <img src="{{ asset('images/majales.svg') }}" alt="مجالس النظارة" class="h-10 md:h-13">
                        <div class="w-px h-8 md:h-10 bg-gray-300/50"></div>
                        <img src="{{ asset('images/sna.svg') }}" alt="سنا المستقبل" class="h-9 md:h-11">
                        <div class="w-px h-8 md:h-10 bg-gray-300/50"></div>
                        <img src="{{ asset('images/iwqf.svg') }}" alt="iwqf" class="h-9 md:h-11">
                    </div>
                </div>
                
                <!-- Welcome Text -->
                <div class="mb-12 tracking-wide space-y-4">
                    <h1 class="text-4xl md:text-5xl font-black text-primary leading-tight">
                        أهلاً بك في عالم الأوقاف والوصايا<br>
                        <span class="text-3xl md:text-4xl text-secondary font-bold block mt-3">فقد وصلت لوقف الأوقاف؛</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-600 leading-relaxed font-medium">
                        ستتجوّل في رحاب خبرةٍ تراكميةٍ امتدت لأكثر من <span class="text-primary font-bold">20 عامــــًا</span>.
                    </p>
                </div>
                
                <!-- Call to Action -->
                <button @click="goTo(2)" class="group mt-2 bg-gradient-to-r from-[#005358] to-[#004145] text-white text-2xl font-bold py-4 px-10 rounded-full shadow-[0_15px_30px_rgba(0,83,88,0.25)] hover:shadow-[0_20px_40px_rgba(0,83,88,0.35)] transition-all transform active:scale-95 flex items-center justify-center gap-4 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></div>
                    <span class="relative">ابدأ رحلتك .. وتعرّف على خدماتنا</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 -scale-x-100 transform group-hover:-translate-x-2 transition-transform relative" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- SCREEN 2: Menu / Split Screen -->
        <div x-show="screen === 2" x-cloak
             x-transition:enter="transition duration-700 ease-out delay-100" 
             x-transition:enter-start="opacity-0 translate-x-12" 
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition duration-500 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-x-12"
             class="absolute inset-0 p-6 flex flex-col items-center justify-center pointer-events-auto h-full">
             
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-primary mb-3">شركة استثمار المستقبل القابضة</h2>
                <p class="text-xl text-secondary font-bold">يرجى اختيار الوجهة المناسبة لك للتعرف على منظومتنا</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-5xl">
                <!-- Option 1: Companies -->
                <div @click="goTo(3)" class="glass-panel group rounded-[2.5rem] p-10 flex flex-col items-center text-center cursor-pointer transform transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,83,88,0.15)] border-2 border-transparent hover:border-primary/20 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-lg mb-8 relative z-10 group-hover:scale-110 transition-transform duration-500 delay-75 border-4 border-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h3 class="text-3xl font-bold text-primary mb-4 z-10">الشركات التابعة للمنظومة</h3>
                    <p class="text-gray-600 text-lg z-10">تعرف على نسيجنا المعرفي وأذرعنا الفنية والإدارية والاستشارية</p>
                    <div class="mt-8 z-10 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                        <span class="bg-primary/10 text-primary font-bold px-6 py-2 rounded-full">استكشف الآن &larr;</span>
                    </div>
                </div>

                <!-- Option 2: Books -->
                <div @click="goTo(4)" class="glass-panel group rounded-[2.5rem] p-10 flex flex-col items-center text-center cursor-pointer transform transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(206,175,135,0.2)] border-2 border-transparent hover:border-secondary/30 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-lg mb-8 relative z-10 group-hover:scale-110 transition-transform duration-500 delay-75 border-4 border-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="text-3xl font-bold text-primary mb-4 z-10">الأبحاث والكتب الجديدة</h3>
                    <p class="text-gray-600 text-lg z-10">اطلع على أحدث إصداراتنا المتخصصة في مجال الأوقاف والوصايا</p>
                    <div class="mt-8 z-10 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                        <span class="bg-secondary/10 text-primary font-bold px-6 py-2 rounded-full">تصفح المكتبة &larr;</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCREEN 3: Companies -->
        <div x-show="screen === 3" x-cloak
             x-transition:enter="transition duration-700 ease-out delay-100" 
             x-transition:enter-start="opacity-0 translate-x-12" 
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition duration-500 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-x-12"
             class="absolute inset-0 p-6 pt-20 pb-12 touch-scroll overflow-y-auto pointer-events-auto h-full flex flex-col justify-center">
             
            <div class="max-w-[70rem] mx-auto w-full">
                <!-- Header -->
                <div class="text-center mb-10 relative">
                    <button @click="goTo(2)" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/50 hover:bg-white text-primary rounded-full p-3 shadow-sm transition-all border border-gray-100 hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </button>
                    <h2 class="text-4xl font-black text-primary mb-2 drop-shadow-sm">منظومة استثمار المستقبل القابضة</h2>
                    <p class="text-xl text-secondary font-bold">شركاتنا الرائدة في خدمة قطاع الأوقاف</p>
                </div>

                <!-- Modern Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6">
                    
                    <!-- Faradah Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-accent to-transparent opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="h-32 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/faradah.svg') }}" alt="فرادة" class="h-14 object-contain z-10 transition-transform group-hover:scale-105">
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6 flex-grow">
                                <span class="font-bold text-accent">الذراع التقني لمنظومة استثمار المستقبل القابضة</span>، وهي تُعنى بتقديم حلول تقنية آمنة لقطاع الأوقاف والوصايا، ومن منتجاتها منصة حباء المتخصصة في إدارة المنح عبر منظومة تقنية متكاملة، ومنصة سواقف المتخصصة في ربط النُظار بمزودي الخدمات، ومنصة وديم المتخصصة في تقديم نماذج الوثائق والوصايا مجانًا.
                            </p>

                            <button @click="openIframe('https://profile.faradah.sa/i')" class="mt-auto flex items-center justify-center gap-2 w-full bg-white/50 text-primary font-bold text-sm py-3 rounded-xl border border-primary/20 hover:bg-primary/5 hover:border-primary/40 transition-colors">
                                <span>زيارة موقع فرادة</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Majales Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group border border-success/20">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-success/50 via-success to-success/50 opacity-100 transition-opacity"></div>
                        
                        <div class="h-32 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/majales.svg') }}" alt="مجالس النظارة" class="h-19 object-contain z-10 transition-transform group-hover:scale-105">
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6 flex-grow">
                                <span class="font-bold text-success">الذراع الإداري والتشغيلي لمنظومة استثمار المستقبل القابضة</span>، والتي تُعنى في تقديم خدمات استشارية في الإدارة والتشغيل عبر باقات نوعية تسهم في تمكين النُظّار من إدارة مشاريع الأوقاف وفق أحدث الممارسات والحلول الآمنة.
                            </p>
                            
                            <button @click="openIframe('https://majalisndarah.sa/')" class="mt-auto flex items-center justify-center gap-2 w-full bg-white/50 text-success font-bold text-sm py-3 rounded-xl border border-success/20 hover:bg-success/5 hover:border-success/40 transition-colors">
                                <span>زيارة موقع مجالس النظارة</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sana Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group border border-secondary/30">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary via-primary to-secondary opacity-100"></div>
                        
                        <div class="h-32 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/sna.svg') }}" alt="سنا المستقبل" class="h-16 object-contain z-10 transition-transform group-hover:scale-105">
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6 flex-grow">
                                <span class="font-bold text-sub">الذراع الاستشاري لمنظومة استثمار المستقبل القابضة</span>، والتي تضم نخبة من كبار المستشارين في قطاع الأوقاف والوصايا؛ لتٌقدم حزمة من الخدمات الشاملة والتي تتمثل في الخدمات الشرعية والقانونية، والحوكمة، والخدمات المالية والاستثمارية، وإدارة المنح الخيري، إضافة إلى الخدمات المتعلقة في إنشاء وإدارة الصناديق الوقفية العائلية.
                            </p>
                            
                            <button @click="openIframe('https://sna.com.sa/')" class="mt-auto flex items-center justify-center gap-2 w-full bg-white/50 text-sub font-bold text-sm py-3 rounded-xl border border-sub/20 hover:bg-sub/5 hover:border-sub/40 transition-colors">
                                <span>زيارة موقع سنا</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- iwqf Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group border border-gray-200">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-gray-400 via-gray-600 to-gray-400 opacity-70"></div>
                        
                        <div class="h-32 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/iwqf.svg') }}" alt="iwqf" class="h-16 object-contain z-10 transition-transform group-hover:scale-105">
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6 flex-grow">
                                <span class="font-bold text-gray-800">الذراع التدريبي لمنظومة استثمار المستقبل</span>، والتي تُعنى في تدريب وتأهيل نُظّار الأوقاف وفق المعايير الدولية الوقفية.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Unified Registration Button -->
                <div class="mt-8 flex justify-center pb-8">
                    <button @click="openForm('all_companies', 'تسجيل اهتمام', 'في خدمات منظومة استثمار المستقبل القابضة', 'المنظومة')" class="bg-gradient-to-r from-primary to-[#004145] text-white text-xl font-bold py-4 px-12 rounded-2xl shadow-[0_15px_30px_rgba(0,83,88,0.25)] hover:shadow-[0_20px_40px_rgba(0,83,88,0.35)] active:scale-95 transition-all flex items-center gap-3 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></div>
                        <span class="relative">سجل اهتمامك بالمنظومة</span>
                        <svg class="w-6 h-6 relative" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- SCREEN 4: Books -->
        <div x-show="screen === 4" x-cloak
             x-transition:enter="transition duration-700 ease-out delay-100" 
             x-transition:enter-start="opacity-0 translate-x-12" 
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition duration-500 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-x-12"
             class="absolute inset-0 p-6 pt-20 pb-12 touch-scroll overflow-y-auto pointer-events-auto h-full flex flex-col justify-center">
             
            <div class="max-w-[65rem] mx-auto w-full">
                <!-- Header -->
                <div class="text-center mb-16 relative">
                    <button @click="goTo(2)" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/50 hover:bg-white text-primary rounded-full p-3 shadow-sm transition-all border border-gray-100 hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </button>
                    <h2 class="text-4xl font-black text-primary mb-2 drop-shadow-sm">إصداراتنا المعرفية</h2>
                    <p class="text-xl text-secondary font-bold">اكتشف أحدث الأبحاث والكتب في مجال الأوقاف</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    <!-- Book 1: حوكمة الأوقاف -->
                    <div class="glass-panel rounded-3xl p-8 flex flex-col sm:flex-row items-center sm:items-stretch gap-8 relative border border-transparent hover:border-secondary/30 transition-all text-center sm:text-right">
                        <!-- Simplified Flat Book Thumbnail -->
                        <div class="shrink-0 w-36 h-52 bg-gradient-to-br from-[#005358] to-[#003135] rounded-lg shadow-xl relative overflow-hidden flex flex-col items-center justify-center">
                            <div class="absolute right-2 top-0 bottom-0 w-[2px] bg-black/10"></div>
                            <div class="text-secondary/60 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                            </div>
                            <h3 class="font-black text-xl text-white mb-1 leading-tight text-center px-1">حوكمة<br>الأوقاف</h3>
                            <p class="text-[0.6rem] text-white/70 mt-auto pb-4">دليل تطبيقي شامل</p>
                        </div>

                        <div class="flex-grow flex flex-col h-full">
                            <h3 class="text-2xl font-black text-primary mb-3">كتاب حوكمة الأوقاف</h3>
                            <p class="text-gray-600 text-sm mb-6 leading-relaxed flex-grow">
                                يعرض هذا الكتاب أفضل الممارسات والمعايير لضمان الشفافية والاستدامة في إدارة الأوقاف وبناء استراتيجية حوكمة متينة.
                            </p>
                            <div class="space-y-3 mt-auto w-full">
                                <button @click="openForm('book', 'طلب نسخة مطبوعة', 'كتاب حوكمة الأوقاف', '', 'حوكمة الأوقاف')" class="w-full flex items-center justify-center gap-2 bg-white text-primary border border-primary/20 hover:bg-primary/5 font-bold text-sm py-3.5 rounded-xl transition-all shadow-sm">
                                    للجهات: اطلب نسختك المطبوعة
                                </button>
                                <button @click="openQRModal('https://drive.google.com/file/d/1mJdIVTBua2mTvkDjTCaE9SQmWagP5Vba/view?usp=sharing')" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-secondary to-[#c29b6f] text-white font-bold text-sm py-3.5 rounded-xl transition-all shadow-md active:scale-95">
                                    <svg class="w-5 h-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    للأفراد: احصل على النسخة الرقمية
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book 2: كتاب الوقف والشركات العائلية -->
                    <div class="glass-panel rounded-3xl p-8 flex flex-col sm:flex-row items-center sm:items-stretch gap-8 relative border border-transparent hover:border-secondary/30 transition-all text-center sm:text-right">
                        <!-- Simplified Flat Book Thumbnail -->
                        <div class="shrink-0 w-36 h-52 bg-gradient-to-br from-[#149b9e] to-[#0d7375] rounded-lg shadow-xl relative overflow-hidden flex flex-col items-center justify-center">
                            <div class="absolute right-2 top-0 bottom-0 w-[2px] bg-black/10"></div>
                            <div class="text-white/60 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <h3 class="font-black text-2xl text-white mb-1 leading-tight text-center px-1">كتاب<br>الوقف والشركات العائلية</h3>
                            <p class="text-[0.6rem] text-white/70 mt-auto pb-4">رؤى وتأملات في الأوقاف</p>
                        </div>

                        <div class="flex-grow flex flex-col h-full">
                            <h3 class="text-2xl font-black text-primary mb-3">كتاب الوقف والشركات العائلية</h3>
                            <p class="text-gray-600 text-sm mb-6 leading-relaxed flex-grow">
                                دراسة بحثية تخصصية تطرح الأوقاف كأداة استراتيجية لحماية الشركات العائلية وضمان استمراريتها عبر الأجيال، من خلال تقديم نماذج عملية وحلول مؤسسية تحفظ الثروات من التشتت، وتحقق التوازن بين الاستدامة المالية والأثر الاجتماعي.
                            </p>
                            <div class="space-y-3 mt-auto w-full">
                                <button @click="openForm('book', 'طلب نسخة مطبوعة', 'كتاب الوقف والشركات العائلية', '', 'كتاب الوقف والشركات العائلية')" class="w-full flex items-center justify-center gap-2 bg-white text-primary border border-primary/20 hover:bg-primary/5 font-bold text-sm py-3.5 rounded-xl transition-all shadow-sm">
                                    للجهات: اطلب نسختك المطبوعة
                                </button>
                                <button @click="openQRModal('https://drive.google.com/file/d/1W9I7ajbtyCqu-3yrJ4Rxhqg14Yino0mB/view?usp=sharing')" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-secondary to-[#c29b6f] text-white font-bold text-sm py-3.5 rounded-xl transition-all shadow-md active:scale-95">
                                    <svg class="w-5 h-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    للأفراد: احصل على النسخة الرقمية
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- SCREEN 5: Unified Form -->
        <div x-show="screen === 5" x-cloak
             x-transition:enter="transition duration-500 ease-out delay-50" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition duration-300 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-0 p-4 flex items-center justify-center pointer-events-auto h-full overflow-hidden">
             
            <div class="w-full max-w-3xl glass-panel bg-white/80 rounded-[2rem] shadow-2xl relative overflow-hidden flex flex-col">
                
                <button @click="goTo(formType === 'book' ? 4 : 3)" class="absolute top-8 right-8 z-30 bg-white/50 hover:bg-white text-primary rounded-full p-2.5 shadow-sm transition-all border border-gray-100 hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                </button>

                <!-- Modern Minimal Header -->
                <div class="bg-primary/5 p-8 pb-4 relative flex items-center justify-between border-b border-primary/10">
                    <div class="pr-12">
                        <h2 class="text-2xl font-black text-primary mb-1" x-text="formTitle"></h2>
                        <p class="text-sm text-secondary font-bold" x-text="formSubTitle"></p>
                    </div>
                    <img x-show="formType === 'sana'" src="{{ asset('images/sna.svg') }}" alt="سنا" class="h-12 object-contain opacity-90 drop-shadow-sm">
                    <img x-show="formType === 'majales'" src="{{ asset('images/majales.svg') }}" alt="مجالس النظارة" class="h-12 object-contain opacity-90 drop-shadow-sm">
                </div>

                <!-- Form Area -->
                <div class="p-8 relative">
                    <form @submit.prevent="submitForm" id="interestForm" data-page-type="شاشة العرض الموحدة" class="space-y-6 relative z-10">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-bold text-gray-700">الاسم <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" required placeholder="أدخل اسمك الكريم" 
                                       class="w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-gray-400/80 shadow-sm">
                            </div>
                            
                            <!-- Phone -->
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-bold text-gray-700">الجوال <span class="text-danger">*</span></label>
                                <input type="tel" id="phone" name="phone" required placeholder="05XXXXXXXX" dir="ltr"
                                       class="w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-right placeholder:text-gray-400/80 shadow-sm font-sans">
                            </div>
                        </div>

                        <!-- Entity Field (for Books) -->
                        <div x-show="formType === 'book'" class="space-y-2 pt-2" x-transition>
                            <label for="entity" class="block text-sm font-bold text-gray-700">جهة العمل (الجهة الوقفية) <span class="text-danger">*</span></label>
                            <input type="text" id="entity" name="entity" x-bind:required="formType === 'book'" placeholder="اسم الجهة أو المؤسسة" 
                                   class="w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-gray-400/80 shadow-sm">
                        </div>

                        <!-- Service Type Dropdown (for Sana) -->
                        <div x-show="formType === 'sana'" class="space-y-2 pt-2" x-transition>
                            <label for="service" class="block text-sm font-bold text-gray-700">اختر نوع الخدمة الإدارية والتشغيلية <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select id="service" name="service" x-bind:required="formType === 'sana'" class="appearance-none w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm cursor-pointer pr-10 text-gray-700 bg-no-repeat bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"%238b9d90\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>')] bg-[position:left_1rem_center]">
                                    <option value="" disabled selected class="text-gray-400">الرجاء اختيار الخدمة المناسبة</option>
                                    <option value="الخدمات الشرعية والقانونية">الخدمات الشرعية والقانونية</option>
                                    <option value="خدمات الحوكمة">خدمات الحوكمة</option>
                                    <option value="الخدمات المالية والاستثمارية">الخدمات المالية والاستثمارية</option>
                                    <option value="خدمات المنح الخيري">خدمات المنح الخيري</option>
                                    <option value="خدمات الصناديق العائلية">الخدمات الصناديق العائلية</option>
                                </select>
                            </div>
                        </div>

                        <!-- Company Selection Dropdown (for Unified Form) -->
                        <div x-show="formType === 'all_companies'" class="space-y-3 pt-2" x-transition>
                            <label class="block text-sm font-bold text-gray-700">الخدمة المطلوبة <span class="text-danger">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <label class="border border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm relative group overflow-hidden">
                                    <div class="absolute inset-0 bg-primary/5 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                                    <div class="absolute inset-0 border-2 border-transparent group-has-[:checked]:border-primary rounded-xl transition-colors"></div>
                                    <input type="checkbox" name="service[]" value="شركة فرادة - المنتجات الرقمية" class="w-5 h-5 text-primary bg-gray-100 border-gray-300 focus:ring-primary rounded z-10 cursor-pointer">
                                    <span class="text-sm font-bold text-gray-800 z-10 leading-relaxed">شركة فرادة - المنتجات الرقمية</span>
                                </label>
                                
                                <label class="border border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm relative group overflow-hidden">
                                    <div class="absolute inset-0 bg-success/5 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                                    <div class="absolute inset-0 border-2 border-transparent group-has-[:checked]:border-success rounded-xl transition-colors"></div>
                                    <input type="checkbox" name="service[]" value="مجالس النظارة - الخدمات الإدارية والتشغيلية" class="w-5 h-5 text-success bg-gray-100 border-gray-300 focus:ring-success rounded z-10 cursor-pointer">
                                    <span class="text-sm font-bold text-gray-800 z-10 leading-relaxed">مجالس النظارة - الخدمات الإدارية والتشغيلية</span>
                                </label>
                                
                                <label class="border border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm relative group overflow-hidden">
                                    <div class="absolute inset-0 bg-sub/5 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                                    <div class="absolute inset-0 border-2 border-transparent group-has-[:checked]:border-sub rounded-xl transition-colors"></div>
                                    <input type="checkbox" name="service[]" value="سنا المستقبل - الخدمات الاستشارية والقانونية" class="w-5 h-5 text-sub bg-gray-100 border-gray-300 focus:ring-sub rounded z-10 cursor-pointer">
                                    <span class="text-sm font-bold text-gray-800 z-10 leading-relaxed">سنا المستقبل - الخدمات الاستشارية والقانونية</span>
                                </label>
                                
                                <label class="border border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm relative group overflow-hidden">
                                    <div class="absolute inset-0 bg-gray-100 opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                                    <div class="absolute inset-0 border-2 border-transparent group-has-[:checked]:border-gray-400 rounded-xl transition-colors"></div>
                                    <input type="checkbox" name="service[]" value="اي وقف - خدمات التدريب و التأهيل" class="w-5 h-5 text-gray-600 bg-gray-100 border-gray-300 focus:ring-gray-500 rounded z-10 cursor-pointer">
                                    <span class="text-sm font-bold text-gray-800 z-10 leading-relaxed">اي وقف - خدمات التدريب و التأهيل</span>
                                </label>
                            </div>
                        </div>

                        <!-- Readonly Book Title shown dynamically -->
                        <div x-show="formType === 'book'" class="space-y-2 pt-2" x-transition>
                            <label class="block text-sm font-bold text-gray-700">الكتاب المطلوب</label>
                            <div class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-200 rounded-xl flex items-center text-primary font-bold shadow-inner">
                                <span x-text="selectedBook"></span>
                            </div>
                        </div>

                        <!-- Meta Info -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-[#004145] text-white text-lg font-bold py-3.5 rounded-xl shadow-[0_10px_20px_rgba(0,83,88,0.2)] hover:shadow-[0_15px_25px_rgba(0,83,88,0.3)] transform active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <span class="drop-shadow-sm" x-text="formType === 'book' ? 'إرسال الطلب' : 'تسجيل واطلب التواصل'"></span>
                            </button>
                        </div>
                    </form>

                    <!-- Instant Success State -->
                    <div x-show="showSuccess" x-cloak
                         x-transition:enter="transition duration-400 ease-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0 bg-white/95 backdrop-blur-md z-20 flex flex-col items-center justify-center p-8 rounded-b-[2rem] text-center border-t border-gray-100">
                        
                        <div class="w-24 h-24 bg-gradient-to-br from-success/20 to-success/5 rounded-full flex items-center justify-center mb-6 shadow-inner relative">
                            <div class="absolute inset-0 rounded-full border border-success/30 animate-ping opacity-50"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-primary mb-3">تم تسجيل وتوثيق طلبك!</h3>
                        <p class="text-base text-gray-600 mb-8 max-w-sm mx-auto">
                            نسعد باهتمامك، سيقوم فريقنا المختص بالتواصل معك قريباً.
                        </p>
                        
                        <button @click="resetToHome()" class="px-8 py-3 bg-gray-50 text-primary font-bold rounded-xl border border-gray-200 shadow-sm hover:bg-gray-100 hover:border-primary/30 transition-all mx-auto">
                            العودة للرئيسية
                        </button>
                    </div>

                    <!-- Error State -->
                    <div x-show="showError" x-cloak
                         x-transition:enter="transition duration-300 ease-out"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition duration-300 ease-in"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-4"
                         class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white text-danger border border-danger/20 py-3 px-6 rounded-lg font-bold text-sm shadow-[0_10px_30px_rgba(232,73,60,0.15)] flex items-center gap-2 z-30 w-max">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                         يوجد مشكلة في الإرسال، الرجاء المحاولة مجدداً.
                    </div>

                </div>
            </div>
        </div>

        <!-- QR Code Modal Backdrop -->
        <div x-show="showQRModal" x-cloak
             x-transition:enter="transition duration-300 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-300 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[60] bg-black/40 backdrop-blur-xl flex items-center justify-center p-4">
            
            <!-- Modal Content -->
            <div @click.away="closeQRModal()"
                 x-show="showQRModal"
                 x-transition:enter="transition duration-400 ease-out delay-100"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition duration-300 ease-in"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="bg-white rounded-[2rem] p-10 max-w-xs w-full text-center relative shadow-2xl border border-white/50">
                 
                <button @click="closeQRModal()" class="absolute top-5 right-5 text-gray-400 hover:text-primary transition-colors bg-gray-50 rounded-full p-2 hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <div class="mb-6 mt-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-secondary/20 to-secondary/5 text-secondary rounded-full flex items-center justify-center mx-auto mb-4 border border-secondary/20 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-primary mb-2">النسخة الرقمية</h3>
                    <p class="text-sm text-gray-600 font-bold">امسح الرمز بكاميرا الجوال للتحميل</p>
                </div>

                <!-- Fake QR Code Container -->
                <div class="bg-white border-2 border-gray-100 p-4 rounded-xl shadow-inner mx-auto w-48 h-48 flex items-center justify-center relative overflow-hidden group mb-2">
                    <img :src="currentQRUrl ? ('https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' + encodeURIComponent(currentQRUrl)) : 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://estithmar.example.com'" alt="QR Code" class="w-full h-full object-contain mix-blend-multiply opacity-90 transition-transform duration-500 group-hover:scale-105">
                    
                    <!-- Scanning line animation -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/50 to-transparent shadow-[0_0_15px_rgba(0,83,88,0.5)] animate-[scan_2.5s_ease-in-out_infinite]"></div>
                </div>
                
                <style>
                    @keyframes scan {
                        0% { top: -5%; opacity: 0; }
                        10% { opacity: 1; }
                        90% { opacity: 1; }
                        100% { top: 105%; opacity: 0; }
                    }
                </style>

            </div>
        </div>

        <!-- Iframe Pop-up Modal -->
        <div x-show="showIframeModal" x-cloak
             x-transition:enter="transition duration-300 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-300 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[70] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 md:p-10">
            
            <div @click.away="closeIframe()"
                 x-show="showIframeModal"
                 x-transition:enter="transition duration-400 ease-out delay-100"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition duration-300 ease-in"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                 class="bg-white rounded-[2rem] w-[95vw] h-full max-h-[95vh] relative shadow-2xl overflow-hidden flex flex-col border border-white/20">
                 
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-primary">استعراض الموقع</h3>
                    <button @click="closeIframe()" class="text-gray-400 hover:text-danger hover:bg-danger/10 p-2 rounded-full transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Iframe Container -->
                <div class="flex-grow w-full relative bg-gray-100">
                    <div x-show="iframeLoading" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-10 h-10 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                    </div>
                    <!-- Template ensures it loads only when requested -->
                    <template x-if="showIframeModal">
                        <iframe :src="currentIframeUrl" @load="iframeLoading = false" class="w-full h-full border-none relative z-10 bg-white"></iframe>
                    </template>
                </div>
            </div>
        </div>

    </div>

    <script>
        function exhibition() {
            return {
                screen: 1,
                resetTimeout: null,
                showSuccess: false,
                showError: false,
                
                showQRModal: false,
                currentQRUrl: '',
                showIframeModal: false,
                currentIframeUrl: '',
                iframeLoading: true,
                formTitle: '',
                formSubTitle: '',
                formType: '', // 'majales', 'sana', 'book'
                selectedCompany: '',
                selectedBook: '',
                
                init() {
                    this.resetTimer();
                },
                
                resetTimer() {
                    clearTimeout(this.resetTimeout);
                    this.resetTimeout = setTimeout(() => {
                        this.resetToHome();
                    }, 120000); // 2 minutes auto-reset
                },
                
                goTo(screenNumber) {
                    this.screen = screenNumber;
                    this.showQRModal = false;
                    this.resetTimer();
                },

                openForm(type, title, subtitle, company, book = null) {
                    this.formType = type;
                    this.formTitle = title;
                    this.formSubTitle = subtitle;
                    this.selectedCompany = company;
                    this.selectedBook = book;
                    
                    this.goTo(5); // Unified Form Screen
                },

                openQRModal(url = '') {
                    this.currentQRUrl = url;
                    this.showQRModal = true;
                    this.resetTimer();
                },
                
                closeQRModal() {
                    this.showQRModal = false;
                },

                openIframe(url) {
                    this.currentIframeUrl = url;
                    this.iframeLoading = true;
                    this.showIframeModal = true;
                    this.resetTimer();
                },
                
                closeIframe() {
                    this.showIframeModal = false;
                    setTimeout(() => {
                        this.currentIframeUrl = '';
                    }, 300);
                },

                resetToHome() {
                    this.screen = 1;
                    this.showSuccess = false;
                    this.showError = false;
                    this.showQRModal = false;
                    this.showIframeModal = false;
                    const form = document.querySelector('#interestForm');
                    if(form) form.reset();
                },
                
                submitForm() {
                    // SILENT AND INSTANT SUBMISSION
                    // The user requested NO WAITING time before showing success.
                    // We immediately show success, and trigger the fetch in the background.
                    
                    this.showError = false;
                    const SCRIPT_URL = 'https://script.google.com/macros/s/AKfycbxbZyMuoZ_xSuW3HH8-wjjD3XPywJDRPTKDfd6lIecIWpVsKVQygk1CmmCYskRsJr5qqA/exec';
                    const form = document.getElementById('interestForm');
                    const formData = new FormData(form);
                    const data = new URLSearchParams();

                    const entity = formData.get('entity') || '';
                    const book = this.selectedBook || '';
                    
                    let finalNotes = formData.get('notes') || 'تم الطلب عبر نظام شاشة المعرض التفاعلية';
                    if (entity) finalNotes += ` | جهة العمل: ${entity}`;
                    if (book) finalNotes += ` | الكتاب المطلوب: ${book}`;
                    
                    let serviceVal = '';
                    if (this.formType === 'all_companies') {
                        const selectedServices = formData.getAll('service[]');
                        serviceVal = selectedServices.length > 0 ? selectedServices.join('، ') : 'لم يتم التحديد';
                    } else {
                        serviceVal = formData.get('service') || this.formTitle || '';
                    }

                    data.append('name', formData.get('name') || '');
                    data.append('phone', formData.get('phone') || '');
                    data.append('company', this.selectedCompany || 'غير محدد');
                    data.append('service', serviceVal);
                    data.append('notes', finalNotes);

                    data.append('pageType', formData.get('pageType') || 'شاشة العرض الموحدة (تصميم حديث)');
                    data.append('deviceType', 'Kiosk / TouchScreen');
                    data.append('browser', navigator.userAgent);
                    data.append('os', navigator.platform || 'Unknown');
                    data.append('screenSize', `${window.screen.width}x${window.screen.height}`);
                    data.append('viewportSize', `${window.innerWidth}x${window.innerHeight}`);
                    data.append('timestamp', new Date().toISOString());
                    data.append('timezone', Intl.DateTimeFormat().resolvedOptions().timeZone);

                    // Show success instantly
                    this.showSuccess = true;
                    
                    setTimeout(() => {
                        if(this.showSuccess) {
                            this.resetToHome();
                        }
                    }, 8000);

                    // Background Network Request
                    fetch(SCRIPT_URL, {
                        method: 'POST',
                        mode: 'no-cors',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: data
                    })
                    .then(() => {
                        console.log('Background silent submission complete.');
                    })
                    .catch(error => {
                        console.error('Background submission error (silent bypass):', error);
                        // We intentionally don't drop the success state since the user asked for instant transition, 
                        // but if it completely fails to send, we might quietly log it.
                    });
                }
            }
        }
    </script>
</body>
</html>
