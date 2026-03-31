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
                    
                    <div class="flex items-center justify-center gap-8 glass-panel px-8 py-5 rounded-2xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-[200%] group-hover:animate-[shimmer_2s_infinite]"></div>
                        <img src="{{ asset('images/faradah.svg') }}" alt="فرادة" class="h-9 hover:scale-110 transition-transform duration-300">
                        <div class="w-px h-10 bg-gray-300/50"></div>
                        <img src="{{ asset('images/majales.svg') }}" alt="مجالس النظارة" class="h-13 hover:scale-110 transition-transform duration-300">
                        <div class="w-px h-10 bg-gray-300/50"></div>
                        <img src="{{ asset('images/sna.svg') }}" alt="سنا المستقبل" class="h-11 hover:scale-110 transition-transform duration-300">
                    </div>
                </div>
                
                <!-- Welcome Text -->
                <div class="mb-12 tracking-wide space-y-4">
                    <h1 class="text-4xl md:text-5xl font-black text-primary leading-tight">
                        أهلاً بك في عالم الأوقاف والوصايا<br>
                        <span class="text-3xl md:text-4xl text-secondary font-bold block mt-3">فقد وصلت لوقف للأوقاف؛</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-600 leading-relaxed font-medium">
                        ستتجوّل في رحاب خبرةٍ تراكميةٍ امتدت لأكثر من <span class="text-primary font-bold">20 عامــــًا</span>.
                    </p>
                </div>
                
                <!-- Call to Action -->
                <button @click="goTo(2)" class="group mt-2 bg-gradient-to-r from-[#005358] to-[#004145] text-white text-2xl font-bold py-4 px-10 rounded-full shadow-[0_15px_30px_rgba(0,83,88,0.25)] hover:shadow-[0_20px_40px_rgba(0,83,88,0.35)] transition-all transform active:scale-95 flex items-center justify-center gap-4 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></div>
                    <span class="relative">ابدأ رحلتك وتعرّف على خدماتنا</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 -scale-x-100 transform group-hover:-translate-x-2 transition-transform relative" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- SCREEN 2: Companies -->
        <div x-show="screen === 2" x-cloak
             x-transition:enter="transition duration-700 ease-out delay-100" 
             x-transition:enter-start="opacity-0 translate-x-12" 
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition duration-500 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-x-12"
             class="absolute inset-0 p-6 pt-20 pb-12 touch-scroll overflow-y-auto pointer-events-auto h-full flex flex-col justify-center">
             
            <div class="max-w-[70rem] mx-auto w-full">
                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-black text-primary mb-2 drop-shadow-sm">نسيجنا المعرفي وأذرعنا</h2>
                    <p class="text-xl text-secondary font-bold">تعرّف على شركات استثمار المستقبل القابضة</p>
                </div>

                <!-- Modern Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Faradah Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group">
                        <!-- Decorative top gradient -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-accent to-transparent opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="h-36 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/faradah.svg') }}" alt="فرادة" class="h-14 object-contain z-10 transition-transform group-hover:scale-105">
                            <span class="absolute top-4 right-4 bg-accent/10 text-primary font-bold px-3 py-1 rounded-full text-xs z-10">الذراع التقني</span>
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                                تُعنى بتقديم حلول تقنية آمنة لقطاع الأوقاف والوصايا وتطوير منظومات الأوقاف الحيوية.
                            </p>
                            
                            <h4 class="font-bold text-primary text-sm mb-3">أبرز المنصات:</h4>
                            <ul class="space-y-3 flex-grow text-sm mb-6 pb-4 border-b border-gray-100">
                                <li class="flex items-start gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-success mt-1.5 shrink-0 shadow-[0_0_8px_rgba(0,180,141,0.5)]"></div>
                                    <div><span class="font-bold text-primary">حباء:</span> إدارة المنح رقمياً.</div>
                                </li>
                                <li class="flex items-start gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-sub mt-1.5 shrink-0 shadow-[0_0_8px_rgba(20,155,158,0.5)]"></div>
                                    <div><span class="font-bold text-primary">سواقف:</span> ربط النُظار بمزودي الخدمة.</div>
                                </li>
                                <li class="flex items-start gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-secondary mt-1.5 shrink-0 shadow-[0_0_8px_rgba(206,175,135,0.5)]"></div>
                                    <div><span class="font-bold text-primary">وديم:</span> نماذج ووثائق الأوقاف المجانية.</div>
                                </li>
                            </ul>

                            <a href="https://profile.faradah.sa/" target="_blank" class="mt-auto flex items-center justify-center gap-2 w-full bg-white/50 text-primary font-bold text-sm py-3 rounded-xl border border-primary/20 hover:bg-primary/5 hover:border-primary/40 transition-colors">
                                <span>زيارة موقع فرادة</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Majales Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-success to-transparent opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="h-36 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/majales.svg') }}" alt="مجالس النظارة" class="h-19 object-contain z-10 transition-transform group-hover:scale-105">
                            <span class="absolute top-4 right-4 bg-success/10 text-success font-bold px-3 py-1 rounded-full text-xs z-10">الذراع الإداري</span>
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6 flex-grow">
                                الذراع الإداري والتشغيلي للمنظومة، تُعنى بتقديم خدمات استشارية تشغيلية لتسهيل ومأسسة أعمال النظّار ومشاريع الأوقاف.
                            </p>
                            
                            <a href="https://majalisndarah.sa/" target="_blank" class="mt-auto block text-center bg-success/10 text-success font-bold text-sm py-3 rounded-xl border border-success/20 hover:bg-success hover:text-white transition-colors">
                                عرض الباقات الإدارية
                            </a>
                        </div>
                    </div>

                    <!-- Sana Card -->
                    <div class="glass-panel rounded-3xl overflow-hidden flex flex-col transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] relative group border border-secondary/30">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary via-primary to-secondary opacity-100"></div>
                        
                        <div class="h-36 flex items-center justify-center relative p-6">
                            <img src="{{ asset('images/sna.svg') }}" alt="سنا المستقبل" class="h-16 object-contain z-10 transition-transform group-hover:scale-105">
                            <span class="absolute top-4 right-4 bg-sub/10 text-sub font-bold px-3 py-1 rounded-full text-xs z-10">الذراع الاستشاري</span>
                        </div>
                        
                        <div class="p-6 pt-0 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 leading-relaxed mb-6 flex-grow">
                                نخبة من أميز المستشارين لتقديم حزم الخدمات الشرعية، والقانونية، والحوكمة، والاستثمارية بشكل احترافي وناضج لقطاع الأوقاف.
                            </p>
                            
                            <div class="mt-auto space-y-2">
                                <button @click="goTo(3)" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-[#004145] text-white font-bold text-sm py-3.5 rounded-xl shadow-lg hover:shadow-primary/30 active:scale-95 transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    سجل اهتمامك فوراً
                                </button>
                                <a href="https://sna.com.sa/" target="_blank" class="block w-full text-center text-xs text-gray-500 hover:text-primary transition-colors py-1">
                                    أو زيارة الموقع الإلكتروني
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- SCREEN 3: Interest Form (Sana) -->
        <div x-show="screen === 3" x-cloak
             x-transition:enter="transition duration-500 ease-out delay-50" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition duration-300 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-0 p-4 flex items-center justify-center pointer-events-auto h-full overflow-hidden">
             
            <div class="w-full max-w-3xl glass-panel bg-white/80 rounded-[2rem] shadow-2xl relative overflow-hidden flex flex-col">
                
                <!-- Modern Minimal Header -->
                <div class="bg-primary/5 p-8 pb-4 relative flex items-center justify-between border-b border-primary/10">
                    <div>
                        <h2 class="text-2xl font-black text-primary mb-1">طلب استشارة أو خدمة</h2>
                        <p class="text-sm text-secondary font-bold">بواسطة خبراء سنا المستقبل الاستشارية</p>
                    </div>
                    <img src="{{ asset('images/sna.svg') }}" alt="سنا" class="h-12 object-contain opacity-90 drop-shadow-sm">
                </div>

                <!-- Form Area -->
                <div class="p-8 relative">
                    <form @submit.prevent="submitForm" id="interestForm" data-page-type="شاشة العرض الموحدة" class="space-y-6 relative z-10">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-bold text-gray-700">الاسم <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" required placeholder="أدخل الاسم أو الجهة" 
                                       class="w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-gray-400/80 shadow-sm">
                            </div>
                            
                            <!-- Phone -->
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-bold text-gray-700">الجوال <span class="text-danger">*</span></label>
                                <input type="tel" id="phone" name="phone" required placeholder="05XXXXXXXX" dir="ltr"
                                       class="w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-right placeholder:text-gray-400/80 shadow-sm font-sans">
                            </div>
                        </div>

                        <!-- Service Type Dropdown -->
                        <div class="space-y-2 pt-2">
                            <label for="service" class="block text-sm font-bold text-gray-700">نوع الخدمة المرجوة <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select id="service" name="service" required class="appearance-none w-full h-12 px-4 text-base bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm cursor-pointer pr-10 text-gray-700 bg-no-repeat bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"%238b9d90\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>')] bg-[position:left_1rem_center]">
                                    <option value="" disabled selected class="text-gray-400">الرجاء اختيار الخدمة المناسبة</option>
                                    <option value="الخدمات الشرعية والقانونية">الخدمات الشرعية والقانونية</option>
                                    <option value="خدمات الحوكمة">خدمات الحوكمة</option>
                                    <option value="الخدمات المالية والاستثمارية">الخدمات المالية والاستثمارية</option>
                                    <option value="خدمات المنح الخيري">خدمات المنح الخيري</option>
                                    <option value="خدمات الصناديق العائلية">الخدمات الصناديق العائلية</option>
                                </select>
                            </div>
                        </div>

                        <!-- Meta Info -->
                        <input type="hidden" name="notes" value="تم الطلب عبر نظام شاشة المعرض التفاعلية">
                        <input type="hidden" name="company" value="سنا المستقبل الاستشارية">

                        <div class="pt-6">
                            <!-- Button without waiting state -> instant visual submit -->
                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-[#004145] text-white text-lg font-bold py-3.5 rounded-xl shadow-[0_10px_20px_rgba(0,83,88,0.2)] hover:shadow-[0_15px_25px_rgba(0,83,88,0.3)] transform active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <span class="drop-shadow-sm">تسجيل واطلب التواصل</span>
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
                        <p class="text-base text-gray-600 mb-8 max-w-sm">
                            نسعد باهتمامك، سيقوم فريقنا المختص بالتواصل معك قريباً.
                        </p>
                        
                        <button @click="resetToHome()" class="px-8 py-3 bg-gray-50 text-primary font-bold rounded-xl border border-gray-200 shadow-sm hover:bg-gray-100 hover:border-primary/30 transition-all">
                            العودة للرئيسية
                        </button>
                    </div>

                    <!-- Error State (Subtle Toast) -->
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

    </div>

    <script>
        function exhibition() {
            return {
                screen: 1,
                resetTimeout: null,
                showSuccess: false,
                showError: false,
                
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
                    this.resetTimer();
                },

                resetToHome() {
                    this.screen = 1;
                    this.showSuccess = false;
                    this.showError = false;
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

                    data.append('name', formData.get('name') || '');
                    data.append('phone', formData.get('phone') || '');
                    data.append('company', formData.get('company') || '');
                    data.append('service', formData.get('service') || '');
                    data.append('notes', formData.get('notes') || '');

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
