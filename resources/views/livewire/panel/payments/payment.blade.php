<div class="container mx-auto max-w-2xl">

    {{-- کارت اصلی نتیجه --}}

    <div class="rounded-2xl shadow-2xl py-22px px-4 transition-all duration-300
{{ $isSuccessful ? 'bg-green-50 border-t-8 border-green-600 dark:border-green-400 dark:bg-gray-800' : 'bg-red-50 border-t-8 border-red-600 dark:bg-gray-800' }}">

        {{-- بخش هدر و وضعیت --}}
        <div class="flex items-center gap-x-1 rtl:space-x-reverse pb-2 border-b border-gray-200 dark:border-gray-700">
            @if ($isSuccessful)
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">
                    پرداخت موفقیت آمیز
                </h3>
            @else
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">
                    عملیات ناموفق
                </h3>
            @endif
        </div>

        {{-- پیام اصلی --}}
        <p class="pt-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $message }}
        </p>

        {{-- نمایش کد پیگیری (Ref ID) به صورت برجسته --}}
        @if ($payment && $payment->ref_id)
            <div class="mt-2.5 p-4 rounded-xl border border-dashed flex justify-between items-center
    {{ $isSuccessful ? 'border-green-300 bg-green-100 dark:bg-gray-700' : 'border-red-300 bg-red-100 dark:bg-gray-700' }}">
                <div>
                    <p class="text-sm font-semibold
        {{ $isSuccessful ? 'text-green-800 dark:text-green-300' : 'text-red-800 dark:text-red-300' }}">
                        کد پیگیری تراکنش:
                    </p>
                    {{-- Authority همان Ref ID ما است --}}
                    <p id="refIdText" class="text-2xl font-mono tracking-wider break-all mt-1
        {{ $isSuccessful ? 'text-green-900 dark:text-green-400' : 'text-red-900 dark:text-red-400' }}">
                        {{ $payment->ref_id }}
                    </p>
                </div>

                {{-- دکمه کپی --}}
                <button onclick="copyTextById('refIdText')"
                        class="p-2 rounded-lg h-max cursor-pointer transition duration-150 hover:bg-opacity-80
                    {{ $isSuccessful ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                    {{-- آیکون کپی --}}
                    <svg id="copyIcon" class="w-6 h-6 fill-transparent">
                        <use xlink:href="#icon-copy"></use>
                    </svg>
                    {{-- آیکون تایید --}}
                    <svg id="copiedIcon" class="w-6 h-6 fill-transparent hidden">
                        <use xlink:href="#icon-check-circle"></use>
                    </svg>
                </button>
            </div>
        @endif

        {{-- جزئیات اشتراک در صورت موفقیت --}}
        @if ($isSuccessful && $payment && $payment->plan)
            <div class="mt-2.5 pt-4 border-t border-gray-300 dark:border-gray-600">
                <p class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">
                    جزئیات اشتراک:
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    پلن خریداری شده: <span
                        class="font-bold text-green-700 dark:text-green-400">{{ $payment->plan->name ?? 'نامشخص' }}</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    مبلغ پرداخت شده: <span class="font-bold">{{ number_format($payment->amount) }} تومان</span>
                </p>
            </div>
        @endif

        {{-- دکمه‌های اقدام --}}
        <div class="mt-4 flex justify-center space-x-4 rtl:space-x-reverse">
            @if ($isSuccessful)
                {{-- دکمه موفقیت: بازگشت به صفحه اصلی سایت (داشبورد) --}}
                <a href="{{ route('panel.dashboard') }}"
                   class="flex items-center bg-green-600 hover:bg-green-700 dark:bg-green-400 dark:hover:bg-green-500 text-white dark:text-black font-bold py-2.5 px-3.5 rounded-xl transition duration-200 transform hover:scale-[1.02]">
                    بازگشت به صفحه اصلی سایت
                </a>
            @else
                {{-- دکمه ناموفق: رفتن به صفحه لیست تیکت‌ها --}}
                {{-- فرض می‌کنیم route('tickets.index') تعریف شده است --}}
                <a href="{{ route('panel.tickets.index') }}"
                   class="flex items-center bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 px-3.5 rounded-xl transition duration-200 transform hover:scale-[1.02]">
                    رفتن به صفحه لیست تیکت‌ها
                </a>

                {{-- دکمه دوم برای خرید مجدد (اختیاری) --}}
                <a href="{{ route('panel.plans.index') }}"
                   class="flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-3.5 rounded-xl transition duration-200 transform hover:scale-[1.02]">
                    تلاش مجدد
                </a>
            @endif
        </div>

    </div>
</div>

