<div>
    <!-- Tailwind CSS is assumed to be loaded. -->
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- 🔴 Swiper CDN 🔴 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Custom Styles for Premium Look -->
    <style>
        /* 🔴 تم تیره عمیق و حرفه‌ای */
        body {
            background-color: #0a0a0a;
            color: #f1f1f1;
            font-family: 'Inter', sans-serif;
        }

        /* 🔴 استایل کارت‌های فیلم: بک‌گراند تیره، لبه‌های گرد */
        .movie-card-base {
            background-color: #1a1a1a;
            border: 1px solid #2d2d2d;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }

        /* 🔴 افکت هاور پرمیوم روی کارت‌ها */
        .movie-card-base:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 25px rgba(229, 9, 20, 0.3), 0 0 10px rgba(229, 9, 20, 0.1);
            border-color: #e50914;
            z-index: 10;
        }

        /* 🔴 استایل بک‌گراند جزئیات قهرمان (Hero Details) */
        #hero-details-container {
            background-position: center;
            background-size: cover;
            transition: background-image 0.5s ease-in-out;
            min-height: 600px; /* حداقل ارتفاع برای نمایش خوب */
        }

        /* 🔴 افکت Overlay روی Details Box برای خوانایی متن */
        .details-overlay {
            background: linear-gradient(to left,
            rgba(10, 10, 10, 0.7) 0%, /* تیره از سمت اسلایدر */
            rgba(10, 10, 10, 0.2) 50%,
            rgba(10, 10, 10, 0.7) 100% /* تیره از لبه چپ */
            );
        }

        /* 🔴 استایل آیتم‌های اسلایدر عمودی (Swiper) */
        .swiper-slide-item {
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.5; /* غیرفعال پیش‌فرض */
            border: 3px solid transparent;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* 🔴 استایل آیتم فعال اسلایدر عمودی */
        .swiper-slide-active .swiper-slide-item {
            opacity: 1; /* فعال */
            border-color: #e50914; /* هایلایت با رنگ قرمز */
            transform: scale(1.05); /* کمی بزرگ‌تر شدن */
        }

        /* 🔴 گرادیان قوی‌تر روی هدر */
        .header-bg {
            background-color: #0a0a0a;
            background-image: linear-gradient(to bottom, #100000, #0a0a0a);
        }

    </style>
    <!-- End Custom Styles -->

    <!-- 🌟 ۱. هدر (Header) -->
    <header class="sticky top-0 z-50 header-bg backdrop-blur-md shadow-2xl border-b border-red-700/20">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center h-16">

            <!-- لوگو -->
            <a href="#" class="text-3xl font-extrabold text-red-700 tracking-wider hover:text-red-600 transition duration-200">
                CINEMAGATE
            </a>

            <!-- ناوبری اصلی (فقط در دسکتاپ) -->
            <nav class="hidden md:flex gap-8 text-gray-300 font-medium">
                <a href="#" wire:navigate class="text-white relative pb-1 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:w-full">خانه</a>
                <a href="#" wire:navigate class="hover:text-red-500 transition duration-150 relative pb-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-red-600 hover:after:w-full after:transition-all after:duration-300">فیلم‌ها</a>
                <a href="#" wire:navigate class="hover:text-red-500 transition duration-150 relative pb-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-red-600 hover:after:w-full after:transition-all after:duration-300">سریال‌ها</a>
                <a href="#" wire:navigate class="hover:text-red-500 transition duration-150 relative pb-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-red-600 hover:after:w-full after:transition-all after:duration-300">ژانرها</a>
            </nav>

            <!-- دکمه‌ها و جستجو -->
            <div class="flex items-center gap-4">

                <!-- جستجوی دسکتاپ -->
                <div class="hidden lg:block relative">
                    <input type="text" placeholder="جستجوی سریع..."
                           class="py-2 pr-10 pl-4 w-64 rounded-full bg-[#1e1e1e] text-gray-200 border border-gray-700 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200" />
                    <i data-lucide="search" class="w-5 h-5 absolute right-3 top-2.5 text-gray-400"></i>
                </div>

                <!-- دکمه اشتراک -->
                <a href="#" wire:navigate class="hidden sm:inline-flex text-white bg-red-700 hover:bg-red-800 px-4 py-2 rounded-xl font-bold transition duration-300 shadow-lg shadow-red-700/50 text-sm">
                    <i data-lucide="zap" class="w-5 h-5 ml-1"></i>
                    خرید اشتراک
                </a>

                <!-- منوی موبایل (HAMBURGER) -->
                <button class="md:hidden text-gray-300 hover:text-red-500">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- 🎬 ۲. بخش اصلی صفحه (Main Content) -->
    <main class="container mx-auto px-4">

        <!-- ⭐️⭐️⭐️ بخش Hero پویا: اسلایدر عمودی (راست) + باکس جزئیات (چپ) ⭐️⭐️⭐️ -->
        <section class="mb-20 mt-8">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-6 border-r-4 border-red-600 pr-3 flex items-center gap-2">
                <i data-lucide="monitor-dot" class="w-6 h-6 text-red-600"></i>
                برگزیدگان اختصاصی
            </h2>

            <!-- کانتینر اصلی: نمایش اسلایدر در راست و جزئیات در چپ (استفاده از flex-row-reverse برای RTL) -->
            <div class="flex flex-col md:flex-row-reverse gap-6 md:gap-8 min-h-[600px] h-full">

                <!-- 🔴 ۱. اسلایدر عمودی (سمت راست - Vertical Swiper) -->
                <div class="w-full md:w-1/4 lg:w-1/5 min-h-[600px] h-full flex flex-col justify-between">
                    <div id="vertical-hero-slider" class="swiper h-[600px] rounded-xl">
                        <!-- Swiper Wrapper -->
                        <div class="swiper-wrapper">
                            <!-- آیتم‌های اسلاید به صورت عمودی (3 آیتم) -->
                            <!-- (این آیتم‌ها توسط JS در زمان لود صفحه پر می‌شوند) -->
                        </div>

                        <!-- پیمایش (اختیاری) -->
                        <div class="swiper-button-next text-red-600 after:text-xl after:content-[''] after:rotate-90"></div>
                        <div class="swiper-button-prev text-red-600 after:text-xl after:content-[''] after:rotate-90"></div>
                    </div>
                </div>

                <!-- 🔴 ۲. باکس جزئیات (سمت چپ - Hero Details) -->
                <div id="hero-details-container" class="w-full md:w-3/4 lg:w-4/5 bg-gray-900 rounded-xl overflow-hidden relative transition duration-500">

                    <div class="details-overlay absolute inset-0"></div>

                    <!-- محتوای متنی و دکمه‌ها -->
                    <div class="absolute inset-0 p-8 md:p-12 flex flex-col justify-end text-right">

                        <!-- اطلاعات فرعی -->
                        <div id="hero-metadata" class="mb-3 space-y-2">
                            <span id="hero-genres" class="text-sm font-medium text-gray-300 bg-black/50 px-3 py-1 rounded-full border border-red-600/50"></span>
                        </div>

                        <!-- عنوان اصلی -->
                        <h1 id="hero-title" class="text-4xl md:text-6xl font-black text-white drop-shadow-lg mb-4 leading-tight"></h1>

                        <!-- خلاصه داستان -->
                        <p id="hero-description" class="text-base text-gray-200 max-w-xl mb-6 drop-shadow-md"></p>

                        <!-- دکمه‌ها -->
                        <div class="flex gap-4">
                            <button class="flex items-center bg-red-700 hover:bg-red-600 text-white text-lg font-bold py-3 px-8 rounded-xl shadow-xl shadow-red-700/40 transition duration-300">
                                <i data-lucide="play" class="w-5 h-5 ml-2 fill-white"></i>
                                تماشا کنید
                            </button>
                            <button class="flex items-center border border-white/50 hover:border-white text-white text-lg font-bold py-3 px-8 rounded-xl transition duration-300 bg-white/10 backdrop-blur-sm">
                                <i data-lucide="info" class="w-5 h-5 ml-2"></i>
                                اطلاعات بیشتر
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ۵. بخش لیست‌ها و کاروسل‌ها (همانند قبل) -->
        <section class="mb-20 mt-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-8 border-r-4 border-red-600 pr-3 flex items-center gap-3">
                <i data-lucide="flame" class="w-7 h-7 text-red-600 fill-red-600"></i>
                پرطرفدارترین فیلم‌ها
            </h2>

            <!-- کاروسل فیلم‌ها -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <!-- آیتم‌های Placeholder -->
                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3]">
                    <div class="relative">
                        <img src="https://cdn.gapfilm.ir/image/362/panel/30143/portrait.jpg?updateTime=1758112448000" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>
                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">
                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>
                            ۸.۹
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">تایتانیک جدید</h3>
                        <p class="text-xs text-gray-400">۲۰۲۴ | درام</p>
                    </div>
                </a>

                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3] hidden sm:block">
                    <div class="relative">
                        <img src="https://cdn.gapfilm.ir/image/362/panel/29779/portrait.jpg?updateTime=1754488055000" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>
                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">
                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>
                            ۷.۵
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">جنگ ستارگان: میراث</h3>
                        <p class="text-xs text-gray-400">۲۰۲۳ | علمی-تخیلی</p>
                    </div>
                </a>

                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3] hidden md:block">
                    <div class="relative">
                        <img src="https://cdn.gapfilm.ir/image/362/panel/28372/portrait.jpg?updateTime=1727167459000" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>
                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">
                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>
                            ۹.۱
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">فرار بزرگ</h3>
                        <p class="text-xs text-gray-400">۱۹۶۳ | کلاسیک</p>
                    </div>
                </a>
            </div>
        </section>

        <!-- کاروسل ۲: جدیدترین سریال‌های اکران شده -->
        <section class="mb-20">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-8 border-r-4 border-red-600 pr-3 flex items-center gap-3">
                <i data-lucide="monitor-play" class="w-7 h-7 text-red-600"></i>
                سریال‌های تازه منتشر شده
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <!-- آیتم‌های Placeholder -->
                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3]">
                    <div class="relative">
                        <img src="https://cdn.gapfilm.ir/image/362/panel/28372/portrait.jpg?updateTime=1727167459000" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>
                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">
                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>
                            ۸.۴
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">لبه زمان</h3>
                        <p class="text-xs text-gray-400">فصل ۲ | درام</p>
                    </div>
                </a>
                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3] hidden sm:block">
                    <div class="relative">
                        <img src="https://cdn.gapfilm.ir/image/362/panel/29779/portrait.jpg?updateTime=1754488055000" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>
                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">
                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>
                            ۹.۵
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">پادشاهی زمستانی</h3>
                        <p class="text-xs text-gray-400">فصل ۱ | فانتزی</p>
                    </div>
                </a>
            </div>
        </section>

    </main>

    <!-- 🦶 ۶. فوتر (Footer) -->
    <footer class="bg-[#1a1a1a] border-t border-red-700/20 mt-10">
        <div class="container mx-auto px-4 py-10 md:py-16">
            <!-- Footer Content (Same as before) -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">

                <div class="col-span-2 lg:col-span-1">
                    <h3 class="text-2xl font-extrabold text-red-700 mb-4">CINEMAGATE</h3>
                    <p class="text-sm text-gray-400 max-w-xs">
                        دروازه شما به سوی بهترین‌های جهان سینما. تماشای نامحدود، هیجان بی‌انتها.
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">خدمات</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-red-500 transition">تماس با ما</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">قوانین اشتراک</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">حریم خصوصی</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">دسته‌بندی‌ها</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-red-500 transition">سینمای جهان</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">انیمیشن</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">مستند</a></li>
                    </ul>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-lg font-semibold text-white mb-4">ما را دنبال کنید</h4>
                    <div class="flex space-x-5 rtl:space-x-reverse">
                        <a href="#" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="instagram" class="w-7 h-7"></i></a>
                        <a href="#" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="twitter" class="w-7 h-7"></i></a>
                        <a href="#" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="send" class="w-7 h-7"></i></a>
                    </div>
                </div>

            </div>

            <div class="mt-12 pt-6 border-t border-gray-700/50 text-center text-sm text-gray-500">
                &copy; ۲۰۲۴ سینماگیت. توسعه داده شده با Livewire.
            </div>
        </div>
    </footer>

    <!-- 🟢 جاوا اسکریپت برای مدیریت اسلایدر و همگام‌سازی 🟢 -->
    <script>
        // فعال‌سازی آیکون‌ها
        lucide.createIcons();

        // 🔴 ۱. داده‌های اصلی Hero Section
        const heroData = [
            {
                title: "شوالیه تاریکی: خیزش",
                description: "نولان با یک پایان حماسی بازگشته است. شهر گاتهام بار دیگر در خطر است و تنها یک قهرمان می‌تواند آن را نجات دهد. این فیلم پرفروش‌ترین عنوان سال بود.",
                genres: "اکشن، جنایی، درام",
                posterUrl: "https://cdn.gapfilm.ir/image/362/panel/30143/portrait.jpg?updateTime=1758112448000", // پوستر عمودی برای اسلایدر
                backdropUrl: "https://placehold.co/1200x600/1e0e1e/ffffff?text=The+Dark+Knight+Backdrop" // تصویر افقی برای بک‌گراند جزئیات
            },
            {
                title: "فراتر از ستارگان",
                description: "یک درام علمی تخیلی عمیق درباره‌ی یک فضانورد که برای یافتن سیاره‌ای جدید، سفری به لبه کیهان را آغاز می‌کند. ماجراجویی او، تعریف انسان از خانه را تغییر می‌دهد.",
                genres: "علمی-تخیلی، ماجراجویی",
                posterUrl: "https://cdn.gapfilm.ir/image/362/panel/29779/portrait.jpg?updateTime=1754488055000",
                backdropUrl: "https://placehold.co/1200x600/0a1a4a/ffffff?text=Interstellar+Style+Backdrop"
            },
            {
                title: "پادشاهی زمستانی: فصل ۳",
                description: "بازگشت مورد انتظار سریال فانتزی حماسی. پادشاهی در آستانه جنگ داخلی قرار دارد و قهرمانان قدیمی برای آخرین نبرد گرد هم می‌آیند.",
                genres: "فانتزی، حماسی، درام",
                posterUrl: "https://cdn.gapfilm.ir/image/362/panel/28372/portrait.jpg?updateTime=1727167459000",
                backdropUrl: "https://cdn.gapfilm.ir/image/362/panel/28372/portrait.jpg?updateTime=1727167459000"
            }
        ];

        const detailsContainer = document.getElementById('hero-details-container');
        const heroTitle = document.getElementById('hero-title');
        const heroDescription = document.getElementById('hero-description');
        const heroGenres = document.getElementById('hero-genres');
        const swiperWrapper = document.querySelector('#vertical-hero-slider .swiper-wrapper');


        // 🔴 ۲. تابع به‌روزرسانی محتوای باکس جزئیات
        function updateHeroDetails(index) {
            const data = heroData[index];

            // به‌روزرسانی بک‌گراند با تصویر افقی
            detailsContainer.style.backgroundImage = `url('${data.backdropUrl}')`;

            // به‌روزرسانی محتوای متنی
            heroTitle.textContent = data.title;
            heroDescription.textContent = data.description;
            heroGenres.textContent = data.genres;
        }

        // 🔴 ۳. ایجاد اسلایدهای عمودی بر اساس داده‌ها
        heroData.forEach(item => {
            const slide = document.createElement('div');
            slide.classList.add('swiper-slide');
            slide.innerHTML = `
                <div class="swiper-slide-item w-full aspect-[2/3] md:h-[180px] md:aspect-auto">
                    <img src="${item.posterUrl}" class="w-full h-full object-cover" alt="${item.title}" />
                </div>
            `;
            swiperWrapper.appendChild(slide);
        });

        // 🔴 ۴. راه‌اندازی Swiper و همگام‌سازی
        window.onload = function() {

            // راه‌اندازی Swiper به صورت عمودی
            const heroSwiper = new Swiper('#vertical-hero-slider', {
                direction: 'vertical',
                slidesPerView: 3, // نمایش ۳ آیتم
                spaceBetween: 15,
                centeredSlides: true,
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // 🟠 همگام‌سازی: این بخش اصلی منطق است
                on: {
                    init: function () {
                        // نمایش محتوای آیتم اول در هنگام بارگذاری
                        updateHeroDetails(this.activeIndex);
                    },
                    slideChangeTransitionEnd: function () {
                        // نمایش محتوای آیتم فعال جدید
                        updateHeroDetails(this.activeIndex);
                    },
                },
            });

            // اگر کاربر روی آیتم غیرفعال کلیک کرد، اسلاید را به آنجا ببرد
            heroSwiper.slides.forEach((slide, index) => {
                slide.addEventListener('click', () => {
                    heroSwiper.slideTo(index);
                });
            });

            // 💡 نکته مهم: برای رفرش دکمه‌های آیکون، باید دوباره اجرا شود
            lucide.createIcons();
        };

    </script>
</div>


{{--<div>--}}
{{--    <!-- Lucide Icons CDN: Added to ensure 'lucide' is defined before calling createIcons() -->--}}
{{--    <script src="https://unpkg.com/lucide@latest"></script>--}}

{{--    <!-- Custom Styles for Premium Look (Required for custom colors and shadows) -->--}}
{{--    <style>--}}
{{--        /* 🔴 تم تیره عمیق و حرفه‌ای */--}}
{{--        body {--}}
{{--            background-color: #0a0a0a;--}}
{{--            color: #f1f1f1;--}}
{{--            font-family: 'Inter', sans-serif;--}}
{{--        }--}}

{{--        /* 🔴 استایل کارت‌های فیلم: بک‌گراند تیره، لبه‌های گرد */--}}
{{--        .movie-card-base {--}}
{{--            background-color: #1a1a1a;--}}
{{--            border: 1px solid #2d2d2d;--}}
{{--            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);--}}
{{--            position: relative;--}}
{{--        }--}}

{{--        /* 🔴 افکت هاور پرمیوم روی کارت‌ها */--}}
{{--        .movie-card-base:hover {--}}
{{--            transform: translateY(-5px) scale(1.02); /* کمی کمتر بالا آمدن */--}}
{{--            box-shadow: 0 10px 25px rgba(229, 9, 20, 0.3), 0 0 10px rgba(229, 9, 20, 0.1);--}}
{{--            border-color: #e50914;--}}
{{--            z-index: 10;--}}
{{--        }--}}

{{--        /* 🔴 افکت Overlay روی Hero Items */--}}
{{--        .hero-overlay {--}}
{{--            background: linear-gradient(to top,--}}
{{--            rgba(10, 10, 10, 0.9) 0%,--}}
{{--            rgba(10, 10, 10, 0.6) 30%,--}}
{{--            rgba(10, 10, 10, 0) 100%--}}
{{--            );--}}
{{--        }--}}

{{--        /* 🔴 گرادیان قوی‌تر روی هدر */--}}
{{--        .header-bg {--}}
{{--            background-color: #0a0a0a;--}}
{{--            background-image: linear-gradient(to bottom, #100000, #0a0a0a);--}}
{{--        }--}}
{{--    </style>--}}
{{--    <!-- End Custom Styles -->--}}

{{--    <!-- 🌟 ۱. هدر (Header) - ثابت و با قابلیت ناوبری سریع -->--}}
{{--    <header class="sticky top-0 z-50 header-bg backdrop-blur-md shadow-2xl border-b border-red-700/20">--}}
{{--        <div class="container mx-auto px-4 py-3 flex justify-between items-center h-16">--}}

{{--            <!-- لوگو -->--}}
{{--            <a href="#" class="text-3xl font-extrabold text-red-700 tracking-wider hover:text-red-600 transition duration-200">--}}
{{--                CINEMAGATE--}}
{{--            </a>--}}

{{--            <!-- ناوبری اصلی (فقط در دسکتاپ) -->--}}
{{--            <nav class="hidden md:flex gap-8 text-gray-300 font-medium">--}}
{{--                <a href="#" wire:navigate class="text-white relative pb-1 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-red-600 after:w-full">خانه</a>--}}
{{--                <a href="#" wire:navigate class="hover:text-red-500 transition duration-150 relative pb-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-red-600 hover:after:w-full after:transition-all after:duration-300">فیلم‌ها</a>--}}
{{--                <a href="#" wire:navigate class="hover:text-red-500 transition duration-150 relative pb-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-red-600 hover:after:w-full after:transition-all after:duration-300">سریال‌ها</a>--}}
{{--                <a href="#" wire:navigate class="hover:text-red-500 transition duration-150 relative pb-1 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-red-600 hover:after:w-full after:transition-all after:duration-300">ژانرها</a>--}}
{{--            </nav>--}}

{{--            <!-- دکمه‌ها و جستجو -->--}}
{{--            <div class="flex items-center gap-4">--}}

{{--                <!-- جستجوی دسکتاپ -->--}}
{{--                <div class="hidden lg:block relative">--}}
{{--                    <input type="text" placeholder="جستجوی سریع..."--}}
{{--                           class="py-2 pr-10 pl-4 w-64 rounded-full bg-[#1e1e1e] text-gray-200 border border-gray-700 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200" />--}}
{{--                    <i data-lucide="search" class="w-5 h-5 absolute right-3 top-2.5 text-gray-400"></i>--}}
{{--                </div>--}}

{{--                <!-- دکمه اشتراک -->--}}
{{--                <a href="#" wire:navigate class="hidden sm:inline-flex text-white bg-red-700 hover:bg-red-800 px-4 py-2 rounded-xl font-bold transition duration-300 shadow-lg shadow-red-700/50 text-sm">--}}
{{--                    <i data-lucide="zap" class="w-5 h-5 ml-1"></i>--}}
{{--                    خرید اشتراک--}}
{{--                </a>--}}

{{--                <!-- منوی موبایل (HAMBURGER) -->--}}
{{--                <button class="md:hidden text-gray-300 hover:text-red-500">--}}
{{--                    <i data-lucide="menu" class="w-6 h-6"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </header>--}}

{{--    <!-- 🎬 ۲. بخش اصلی صفحه (Main Content) -->--}}
{{--    <main class="container mx-auto px-4">--}}

{{--        <!-- ⭐️⭐️⭐️ بخش Hero موزاییکی (Grid Mosaic) - متراکم و فشرده ⭐️⭐️⭐️ -->--}}
{{--        <section class="mb-20 mt-8">--}}
{{--            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-6 border-r-4 border-red-600 pr-3 flex items-center gap-2">--}}
{{--                <i data-lucide="monitor-dot" class="w-6 h-6 text-red-600"></i>--}}
{{--                برگزیدگان سینماگیت--}}
{{--            </h2>--}}

{{--            <!-- 🔴 گرید جدید: فشرده‌تر با ارتفاع ردیف‌های ۱۲۰ پیکسلی و چینش نامنظم -->--}}
{{--            <div class="grid grid-cols-6 md:grid-cols-12 gap-4 auto-rows-[200px] md:auto-rows-[120px]">--}}

{{--                <!-- آیتم ۱: عمودی بلند (اصلی) -->--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-4 col-span-6 row-span-3 group">--}}
{{--                    <img src="https://placehold.co/500x1000/0a0a0a/ffffff?text=Series+Spotlight" class="absolute inset-0 w-full h-full object-cover opacity-60 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-6">--}}
{{--                        <span class="text-xs font-semibold bg-red-700 px-2 py-0.5 rounded mb-2 inline-block">سریال برتر</span>--}}
{{--                        <h3 class="text-2xl font-black text-white drop-shadow-lg">قلب زمستانی: فصل نهایی</h3>--}}
{{--                        <p class="text-sm text-gray-300 mt-1">اکشن | فانتزی</p>--}}
{{--                        <button class="mt-3 px-3 py-1.5 text-sm bg-red-600 hover:bg-red-700 rounded-lg text-white font-bold transition">تماشا</button>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <!-- آیتم ۲: افقی عریض (وسط بالا) -->--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-5 col-span-6 row-span-2 group">--}}
{{--                    <img src="https://placehold.co/1000x500/0a0a0a/ffffff?text=Top+Movie+Horizontal" class="absolute inset-0 w-full h-full object-cover opacity-60 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-6">--}}
{{--                        <span class="text-xs font-semibold bg-gray-800 px-2 py-0.5 rounded mb-2 inline-block">فیلم جدید</span>--}}
{{--                        <h3 class="text-xl font-black text-white drop-shadow-lg">سفر به مریخ (۲۰۲۵)</h3>--}}
{{--                        <p class="text-sm text-gray-300 mt-1">اولین نمایش آنلاین.</p>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <!-- آیتم ۳: مربع (گوشه بالا راست) -->--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-3 col-span-3 row-span-2 group">--}}
{{--                    <img src="https://placehold.co/400x400/0a0a0a/ffffff?text=Square+Exclusive" class="w-full h-full object-cover opacity-60 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-4">--}}
{{--                        <span class="text-xs font-semibold bg-green-600 px-2 py-0.5 rounded mb-2 inline-block">۴K HDR</span>--}}
{{--                        <h4 class="text-base font-bold text-white">کیفیت برتر</h4>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <!-- آیتم ۴: کوچکترین (زیر آیتم ۲) -->--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-2 col-span-3 row-span-1 group">--}}
{{--                    <img src="https://placehold.co/300x120/0a0a0a/ffffff?text=Small+Feature" class="w-full h-full object-cover opacity-50 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-3">--}}
{{--                        <h4 class="text-sm font-bold text-white">پردرآمدترین‌ها</h4>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-2 col-span-3 row-span-1 group">--}}
{{--                    <img src="https://placehold.co/300x120/0a0a0a/ffffff?text=Small+Feature" class="w-full h-full object-cover opacity-50 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-3">--}}
{{--                        <h4 class="text-sm font-bold text-white">پردرآمدترین‌ها</h4>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-2 col-span-3 row-span-1 group">--}}
{{--                    <img src="https://placehold.co/300x120/0a0a0a/ffffff?text=Small+Feature" class="w-full h-full object-cover opacity-50 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-3">--}}
{{--                        <h4 class="text-sm font-bold text-white">پردرآمدترین‌ها</h4>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <a href="#" class="movie-card-base rounded-xl overflow-hidden md:col-span-2 col-span-3 row-span-1 group">--}}
{{--                    <img src="https://placehold.co/300x120/0a0a0a/ffffff?text=Small+Feature" class="w-full h-full object-cover opacity-50 transition duration-300 group-hover:opacity-80" />--}}
{{--                    <div class="hero-overlay absolute inset-0"></div>--}}
{{--                    <div class="absolute bottom-0 left-0 p-3">--}}
{{--                        <h4 class="text-sm font-bold text-white">پردرآمدترین‌ها</h4>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--        </section>--}}

{{--        <!-- ۵. بخش لیست‌ها و کاروسل‌ها (جایگاه MovieCarousel) -->--}}
{{--        <section class="mb-20 mt-16">--}}
{{--            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-8 border-r-4 border-red-600 pr-3 flex items-center gap-3">--}}
{{--                <i data-lucide="flame" class="w-7 h-7 text-red-600 fill-red-600"></i>--}}
{{--                پرطرفدارترین فیلم‌ها--}}
{{--            </h2>--}}

{{--            <!-- 🟢 جایگاه کامپوننت لایوایر (با Lazy Loading) -->--}}
{{--            <!-- Livewire::component('site.movie-carousel', ['type' => 'trending_movies']) -->--}}
{{--            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">--}}
{{--                <!-- آیتم‌های Placeholder برای نمایش ساختار -->--}}
{{--                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3]">--}}
{{--                    <div class="relative">--}}
{{--                        <img src="https://placehold.co/300x450/455a64/ffffff?text=Movie+1" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>--}}
{{--                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">--}}
{{--                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>--}}
{{--                            ۸.۹--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="p-3">--}}
{{--                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">تایتانیک جدید</h3>--}}
{{--                        <p class="text-xs text-gray-400">۲۰۲۴ | درام</p>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <!-- آیتم‌های تکراری برای نمایش ردیف -->--}}
{{--                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3] hidden sm:block">--}}
{{--                    <div class="relative">--}}
{{--                        <img src="https://placehold.co/300x450/455a64/ffffff?text=Movie+2" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>--}}
{{--                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">--}}
{{--                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>--}}
{{--                            ۷.۵--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="p-3">--}}
{{--                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">جنگ ستارگان: میراث</h3>--}}
{{--                        <p class="text-xs text-gray-400">۲۰۲۳ | علمی-تخیلی</p>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3] hidden md:block">--}}
{{--                    <div class="relative">--}}
{{--                        <img src="https://placehold.co/300x450/455a64/ffffff?text=Movie+3" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>--}}
{{--                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">--}}
{{--                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>--}}
{{--                            ۹.۱--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="p-3">--}}
{{--                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">فرار بزرگ</h3>--}}
{{--                        <p class="text-xs text-gray-400">۱۹۶۳ | کلاسیک</p>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </section>--}}

{{--        <!-- کاروسل ۲: جدیدترین سریال‌های اکران شده -->--}}
{{--        <section class="mb-20">--}}
{{--            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-8 border-r-4 border-red-600 pr-3 flex items-center gap-3">--}}
{{--                <i data-lucide="monitor-play" class="w-7 h-7 text-red-600"></i>--}}
{{--                سریال‌های تازه منتشر شده--}}
{{--            </h2>--}}

{{--            <!-- 🟢 جایگاه کامپوننت لایوایر (با Lazy Loading) -->--}}
{{--            <!-- Livewire::component('site.movie-carousel', ['type' => 'new_series']) -->--}}
{{--            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">--}}
{{--                <!-- آیتم‌های Placeholder برای نمایش ساختار -->--}}
{{--                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3]">--}}
{{--                    <div class="relative">--}}
{{--                        <img src="https://placehold.co/300x450/455a64/ffffff?text=Series+1" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>--}}
{{--                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">--}}
{{--                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>--}}
{{--                            ۸.۴--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="p-3">--}}
{{--                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">لبه زمان</h3>--}}
{{--                        <p class="text-xs text-gray-400">فصل ۲ | درام</p>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                <a href="#" class="group movie-card-base rounded-xl overflow-hidden aspect-[2/3] hidden sm:block">--}}
{{--                    <div class="relative">--}}
{{--                        <img src="https://placehold.co/300x450/455a64/ffffff?text=Series+2" class="w-full h-auto object-cover aspect-[2/3] transition-opacity duration-300 group-hover:opacity-80"/>--}}
{{--                        <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-bold bg-black/70 text-yellow-400 p-1.5 rounded-lg">--}}
{{--                            <i data-lucide="star" class="w-3 h-3 fill-yellow-400"></i>--}}
{{--                            ۹.۵--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="p-3">--}}
{{--                        <h3 class="text-sm font-bold text-white truncate group-hover:text-red-500 transition">پادشاهی زمستانی</h3>--}}
{{--                        <p class="text-xs text-gray-400">فصل ۱ | فانتزی</p>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </section>--}}

{{--    </main>--}}

{{--    <!-- 🦶 ۶. فوتر (Footer) -->--}}
{{--    <footer class="bg-[#1a1a1a] border-t border-red-700/20 mt-10">--}}
{{--        <div class="container mx-auto px-4 py-10 md:py-16">--}}
{{--            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">--}}

{{--                <!-- بخش ۱: لوگو و شعار -->--}}
{{--                <div class="col-span-2 lg:col-span-1">--}}
{{--                    <h3 class="text-2xl font-extrabold text-red-700 mb-4">CINEMAGATE</h3>--}}
{{--                    <p class="text-sm text-gray-400 max-w-xs">--}}
{{--                        دروازه شما به سوی بهترین‌های جهان سینما. تماشای نامحدود، هیجان بی‌انتها.--}}
{{--                    </p>--}}
{{--                </div>--}}

{{--                <!-- بخش‌های لینک -->--}}
{{--                <div>--}}
{{--                    <h4 class="text-lg font-semibold text-white mb-4">خدمات</h4>--}}
{{--                    <ul class="space-y-3 text-sm text-gray-400">--}}
{{--                        <li><a href="#" class="hover:text-red-500 transition">تماس با ما</a></li>--}}
{{--                        <li><a href="#" class="hover:text-red-500 transition">قوانین اشتراک</a></li>--}}
{{--                        <li><a href="#" class="hover:text-red-500 transition">حریم خصوصی</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--                <div>--}}
{{--                    <h4 class="text-lg font-semibold text-white mb-4">دسته‌بندی‌ها</h4>--}}
{{--                    <ul class="space-y-3 text-sm text-gray-400">--}}
{{--                        <li><a href="#" class="hover:text-red-500 transition">سینمای جهان</a></li>--}}
{{--                        <li><a href="#" class="hover:text-red-500 transition">انیمیشن</a></li>--}}
{{--                        <li><a href="#" class="hover:text-red-500 transition">مستند</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--                <!-- شبکه‌های اجتماعی -->--}}
{{--                <div class="col-span-2 md:col-span-1">--}}
{{--                    <h4 class="text-lg font-semibold text-white mb-4">ما را دنبال کنید</h4>--}}
{{--                    <div class="flex space-x-5 rtl:space-x-reverse">--}}
{{--                        <a href="#" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="instagram" class="w-7 h-7"></i></a>--}}
{{--                        <a href="#" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="twitter" class="w-7 h-7"></i></a>--}}
{{--                        <a href="#" class="text-gray-400 hover:text-red-500 transition"><i data-lucide="send" class="w-7 h-7"></i></a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--            <div class="mt-12 pt-6 border-t border-gray-700/50 text-center text-sm text-gray-500">--}}
{{--                &copy; ۲۰۲۴ سینماگیت. توسعه داده شده با Livewire.--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </footer>--}}

{{--    <!-- فعال‌سازی آیکون‌ها -->--}}
{{--    <script>--}}
{{--        lucide.createIcons();--}}
{{--    </script>--}}
{{--</div>--}}

