<div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 md:p-8 rounded-[10px]">

    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-3">ویرایش اطلاعات حساب</h2>

    <form wire:submit.prevent="updateProfile" class="space-y-8">

        {{-- بخش آپلود آواتار و نمایش پیش‌نمایش --}}
        <div class="flex items-center flex-col md:flex-row space-y-4 gap-x-6">

            {{-- دایره آواتار (فعلی یا پیش‌نمایش) --}}
            <div
                class="relative w-24 h-24 rounded-full border-4 border-indigo-200 dark:border-indigo-700 bg-gray-100 dark:bg-gray-700 overflow-hidden shadow-lg">

                {{-- ۱. پیش‌نمایش عکس جدید (از Livewire - اولویت بالاتر) --}}
                @if ($avatar)
                    {{-- نمایش پیش‌نمایش فایل موقت Livewire --}}
                    <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">

                    {{-- ۲. عکس فعلی کاربر (از دیتابیس با مسیردهی Filament) --}}
                @elseif ($currentAvatar)
                    {{-- از asset برای مسیردهی عمومی و مسیر فایل استفاده می‌کنیم. فرض می‌کنیم 'filament/' دیسک شماست --}}
                    {{-- اگر فایل‌ها در پوشه public/storage/ ذخیره می‌شوند، این مسیر باید به asset('storage/' . ...) تغییر کند --}}
                    {{-- اگر از دیسک Filament استفاده می‌کنید، مسیر معمولاً به شکل زیر است: --}}
                    <img src="{{ asset('uploads/' . $currentAvatar) }}" alt="Current Avatar"
                         class="w-full h-full object-cover">

                    {{-- ۳. آیکون پیش‌فرض --}}
                @else
                    {{-- آیکون جایگزین در صورت نبود عکس --}}
                    <svg class="w-full h-full text-gray-400 dark:text-gray-500 p-4" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M24 20.993c-.346 0-.693-.06-.993-.18-1.012-.416-2.148-.63-3.275-.63-1.077 0-2.19.192-3.235.53C14.49 20.895 12.87 21 12 21c-2.31 0-4.6-.72-6.57-2.08-.94-.64-1.87-1.4-2.65-2.28-1.58-1.78-2.78-3.95-2.78-6.64C0 6.47 5.37 2 12 2s12 4.47 12 9.99c0 2.69-1.2 4.86-2.78 6.64-.78.88-1.71 1.64-2.65 2.28C16.6 20.28 14.31 21 12 21c.87 0 2.49-.105 4.145-.515.283-.07.575-.105.855-.105 1.127 0 2.263.214 3.275.63.3.12.647.18.993.18H24zM12 4c-3.87 0-7 2.76-7 6.16 0 2.47 1.48 4.67 3.7 6.07C9.36 17.06 10.6 17.5 12 17.5s2.64-.44 4.3-1.27c2.22-1.4 3.7-3.6 3.7-6.07C19 6.76 15.87 4 12 4z"/>
                    </svg>
                @endif

                {{-- نمایش وضعیت آپلود موقت --}}
                <div wire:loading wire:target="avatar"
                     class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white font-semibold text-sm rounded-full">
                    در حال آپلود...
                </div>
            </div>

            <div class="flex items-center md:items-start flex-col gap-y-3">
                {{-- دکمه انتخاب فایل --}}
                <label for="avatar_upload"
                       class="cursor-pointer w-max bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200">
                    <span>تغییر عکس آواتار</span>
                    <input
                        id="avatar_upload"
                        type="file"
                        wire:model="avatar"
                        accept="image/jpeg,image/png,image/webp"
                        class="hidden"
                    >
                </label>

                {{-- اعتبارسنجی و توضیحات --}}
                @error('avatar')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium text-center">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">فرمت‌های مجاز: JPG, PNG, WebP. حداکثر
                    حجم: ۲ مگابایت.</p>
            </div>
        </div>

        <div class="space-y-6 grid grid-cols-1 md:grid-cols-2 gap-x-7">
            <!-- نام -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">نام
                    کامل</label>
                <input
                    id="name"
                    type="text"
                    wire:model.live="name"
                    class="w-full rounded-lg p-2.5 bg-border-c border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-2 outline-indigo-600 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 transition duration-150"
                    placeholder="نام خود را وارد کنید"
                >
                @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- ایمیل -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">آدرس
                    ایمیل</label>
                <input
                    id="email"
                    type="email"
                    wire:model.live="email"
                    class="w-full p-2.5 rounded-lg bg-border-c border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-2 outline-indigo-600 transition duration-150"
                    placeholder="example@domain.com"
                >
                @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- دکمه ذخیره -->
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
            <button
                type="submit"
                class="w-full sm:w-auto px-6 py-2 text-white font-semibold bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-md transition duration-200 disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                {{-- هدف loading شامل هم متد آپدیت و هم آپلود موقت آواتار است --}}
                <span wire:loading.remove wire:target="updateProfile, avatar">ذخیره تغییرات</span>
                <span wire:loading wire:target="updateProfile, avatar">در حال ذخیره...</span>
            </button>
        </div>
    </form>

    {{-- اسکریپت Livewire برای ریست کردن فیلد فایل پس از ذخیره --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('resetFileInput', () => {
                const fileInput = document.getElementById('avatar_upload');
                if (fileInput) {
                    // ریست کردن ورودی فایل (ضروری برای آپلود مجدد همان فایل)
                    fileInput.value = '';
                }
            });
        });
    </script>

</div>
