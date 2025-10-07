{{--<div>--}}

{{--    <h2>Hello Plans</h2>--}}

{{--</div>--}}


<div class="container mx-auto p-4 md:p-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
            اشتراک‌های ویژه
        </h1>
        <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
            پلن مورد نظر خود را انتخاب کنید تا از امکانات کامل بهره‌مند شوید.
        </p>
    </div>

    @if ($plans->isEmpty())
        <div
            class="bg-yellow-100 dark:bg-yellow-800 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-200 p-4 rounded-lg"
            role="alert">
            <p class="font-bold">موردی یافت نشد!</p>
            <p>در حال حاضر هیچ پلن فعالی برای نمایش وجود ندارد.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-9 md:gap-6">
            @foreach($plans as $plan)
                <div
                    class="bg-white relative border-[1.4px] border-blue-800 pt-6 pb-18px px-5 overflow-visible dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col justify-between">
                    <div class="flex justify-between pt-5 pb-4">
                        <div class="flex">
                            <h2 class="text-2xl md:text-lg md:pt-1 font-bold text-centertext-gray-900 dark:text-gray-100">{{ $plan->name }}</h2>
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $plan->description }}</p>
                        </div>
                        <div class="flex flex-row gap-y-2.5 items-center justify-center {{ $plan->effectiveDiscountPercent() ? 'gap-x-0.5' : 'gap-x-1' }}">
                            <div class="flex flex-col {{ $plan->effectiveDiscountPercent() ? 'items-center' : '' }}">
                                 <span class="text-xl font-extrabold text-gray-900 dark:text-gray-100">
                            {{ number_format($plan->finalPrice()) }}
                        </span>
                                @if ($plan->hasDiscount())
                                    <span class="text-gray-400 dark:text-gray-500 text-sm line-through">
                                {{ number_format($plan->price) }} تومان
                            </span>
                                @endif
                            </div>

                            <span class="text-black dark:text-gray-100 text-lg font-bold">تومان</span>


                            {{-- نمایش درصد تخفیف --}}
                            @if ($plan->effectiveDiscountPercent() > 0)
                                <div
                                    class="bg-blue-100 border-[1.4px] absolute -top-[22px] right-[34%] md:right-[30%]  dark:bg-blue-900 text-blue-800 dark:text-blue-300 text-sm font-semibold px-5 py-3 rounded-full">
                                    {{ $plan->effectiveDiscountPercent() }}% تخفیف
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <ul class="text-sm flex items-center md:items-start md:flex-col justify-between py-2 text-gray-600 dark:text-gray-400">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2 rtl:ml-2" fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                مدت زمان: {{ $plan->duration_days }} روز
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2 rtl:ml-2" fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                دسترسی به امکانات ویژه
                            </li>
                        </ul>
                    </div>

                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="#" wire:click.prevent="initiatePayment({{ $plan->id }})"
                           class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center font-bold py-3 px-4 rounded-xl transition duration-200">
                            خرید پلن
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
