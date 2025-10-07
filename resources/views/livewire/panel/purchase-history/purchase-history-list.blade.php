<div class="container mx-auto p-4 md:p-6">

    <div class="w-full flex flex-col gap-6">
        {{-- عنوان صفحه --}}
        <div class="w-full flex items-center justify-between border-b pb-2 border-gray-200 dark:border-gray-700">
            <h4 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">سوابق پرداخت‌ها و فاکتورها</h4>
        </div>

        @if ($payments->isEmpty())
            <div class="bg-blue-100 dark:bg-blue-900 border-r-4 border-blue-500 text-blue-700 dark:text-blue-300 p-4 rounded-lg">
                <p>شما تا کنون هیچ تراکنشی ثبت نکرده‌اید.</p>
            </div>
        @else
            {{-- کانتینر اصلی گرید با تنظیمات واکنش‌گرا --}}
            {{-- موبایل (sm:grid-cols-1) - تبلت و دسکتاپ (md:grid-cols-2) --}}
            <div class="w-full grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-5">

                @foreach($payments as $payment)
                    {{-- کارت اصلی پرداخت --}}
                    {{-- h-full برای اطمینان از ارتفاع برابر در گرید --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 pt-3 px-3.5 pb-0 flex flex-col h-full transition-shadow duration-200 hover:shadow-xl">

                        {{-- بخش اول: نام پلن و وضعیت --}}
                        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-gray-700">
                            {{-- نام پلن --}}
                            <div class="flex items-center gap-1">
                                {{-- آیکون خرید (مثال) --}}
                                <svg class="w-6 h-6 fill-transparent text-indigo-500 dark:text-indigo-400">
                                    <use xlink:href="#icon-cart-large"></use>
                                </svg>
{{--                                <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>--}}
{{--                                </svg>--}}
                                <div>
                                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ $payment->plan->name ?? 'پلن نامشخص' }}
                            </span>
                                    @if(!$payment->discount == 0)
                                    <span>{{ $payment->discount . '% تخفیف' ?? '' }} </span>
                                    @endif
                                </div>
                            </div>

                            {{-- وضعیت پرداخت (از متدهای مدل استفاده می‌شود) --}}
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold border-hidden {{ $payment->statusClasses() }}">
                            {{ $payment->statusLabel() }}
                        </span>
                        </div>

                        {{-- بخش دوم: جزئیات (تاریخ و مبلغ) --}}
                        <div class="grid grid-cols-2 gap-4 flex-grow text-gray-700 dark:text-gray-300 mb-4">

                            {{-- تاریخ پرداخت --}}
                            <div class="flex flex-col gap-1">
                                <span class="text-sm opacity-70 dark:text-gray-400">تاریخ پرداخت</span>
                                <span class="font-medium">
                                {{ \Hekmatinasser\Verta\Verta::instance($payment->created_at)->format('Y/m/d') }}
                            </span>
                            </div>

                            {{-- مبلغ پرداخت --}}
                            <div class="flex flex-col gap-1">
                                <span class="text-sm opacity-70 dark:text-gray-400">مبلغ پرداخت</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">
                                {{ number_format($payment->amount) }} تومان
                            </span>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

            {{-- صفحه بندی --}}
            <div class="mt-7 flex justify-center">
                {{ $payments->links('vendor.pagination.custom-pagination-panel-tailwind') }}
            </div>
        @endif
    </div>

</div>
