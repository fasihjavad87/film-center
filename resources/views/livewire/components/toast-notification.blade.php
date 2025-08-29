<div
    x-data="{ show: false, message: '', duration: 3000 }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-full"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-full"
    @toast-notification.window="
    console.log($event.detail);
        show = true;
        message = $event.detail[0].message;
        duration = $event.detail[0].duration || 3000; // اگر زمان ارسال نشد، پیش‌فرض را استفاده کن
        setTimeout(() => show = false, duration);
    "
    class="fixed top-5 right-5 z-50 p-4 rounded-lg shadow-lg text-white bg-green-500">
    <div class="flex items-center gap-x-1.5">
        <svg class="w-6 h-6 mr-2 fill-transparent">
            <use xlink:href="#icon-check-circle"></use>
        </svg>
        <span x-text="message"></span>
    </div>
    <div class="h-1 bg-green-400 mt-2 rounded-full">
        <div class="h-full bg-green-200 animate-slide-in-out"
             :style="{ 'animation-duration': duration + 'ms' }"></div>
    </div>
</div>

