<div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 md:p-8">

    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-3">مدیریت دستگاه‌های فعال</h2>
    <p class="text-gray-600 dark:text-gray-400 mb-8">
        در اینجا می‌توانید تمام دستگاه‌هایی که با حساب شما وارد شده‌اند را مشاهده کنید. در صورت مشاهده فعالیت مشکوک،
        می‌توانید دستگاه مورد نظر را مجبور به خروج کنید.
    </p>

    {{-- لیست دستگاه‌ها --}}
    <div class="space-y-4">
        @forelse ($sessions as $session)
            {{-- رنگ‌بندی بر اساس فعال بودن دستگاه --}}
            <div
                class="px-4 pt-3 md:pb-3 rounded-xl shadow-lg transition duration-200
        {{ $session->is_current ? 'bg-indigo-50 border-2 border-indigo-600 dark:bg-indigo-950 dark:border-indigo-700 pb-0.5' : 'bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 pb-3' }}
    ">

                {{-- تغییر Col Span ها: 5 برای نام، 3 برای جزئیات، 4 برای دکمه (مجموع 12) --}}
                {{-- این نسبت (5-3-4) فضای بیشتری به نام دستگاه می دهد و مشکل شکستن خط را حل می کند --}}
                <div class="grid grid-cols-1 md:[grid-template-columns:repeat(13,minmax(0,1fr))] gap-4 items-center">

                    {{-- بخش آیکون و مرورگر (Col 1-5) --}}
                    <div class="md:col-span-5 flex items-center gap-x-2.5 rtl:space-x-reverse min-w-0">

                        {{-- آیکون دستگاه --}}
                        <div
                            class="p-3 rounded-full flex-shrink-0 {{ $session->is_current ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300' }}">
                            @if (str_contains(strtolower($session->device), 'mobile') || str_contains(strtolower($session->device), 'iphone') || str_contains(strtolower($session->device), 'android'))
                                {{-- آیکون موبایل (Lucide: Smartphone) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect width="14" height="20" x="5" y="2" rx="2" ry="2"/>
                                    <path d="M12 18h.01"/>
                                </svg>
                            @else
                                {{-- آیکون دسکتاپ (Lucide: Monitor) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                                    <line x1="8" x2="16" y1="21" y2="21"/>
                                    <line x1="12" x2="12" y1="17" y2="21"/>
                                </svg>
                            @endif
                        </div>

                        {{-- نام مرورگر و وضعیت --}}
                        <div class="flex flex-col justify-center min-w-0 flex-grow">
                            {{-- flex-wrap و min-w-0 از روی این div حذف شدند --}}
                            <div class="flex items-center gap-x-1.5">
                            <span class="font-bold text-gray-900 dark:text-gray-100 truncate">
                                {{ $session->browser }}
                            </span>
                                <span class="text-sm text-gray-600 dark:text-gray-300">
                                در {{ $session->os }}
                            </span>
                            </div>
                            @if ($session->is_current)
                                <span class="text-xs font-bold text-indigo-700 dark:text-indigo-400 mt-1">
                                دستگاه فعال شما
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- بخش جزئیات (IP & Last Activity) - (Col 6-8) --}}
                    {{-- کاهش Col Span به 3 --}}
                    <div
                        class="md:col-span-4 px-3.5 md:p-0 grid grid-cols-2 text-sm text-gray-700 dark:text-gray-300 gap-2 md:gap-4">

                        {{-- IP Address --}}
                        <div class="flex flex-col">
                            <span class="opacity-70 text-xs text-gray-500 dark:text-gray-400">آدرس IP</span>
                            <span
                                class="font-mono text-xs text-gray-900 dark:text-gray-100">{{ $session->ip_address }}</span>
                        </div>

                        {{-- آخرین فعالیت --}}
                        <div class="flex flex-col">
                            <span class="opacity-70 text-xs text-gray-500 dark:text-gray-400">آخرین فعالیت</span>
                            <span class="text-xs text-gray-900 dark:text-gray-100">{{ $session->last_active_at }}</span>
                        </div>
                    </div>

                    {{-- بخش دکمه حذف (Col 9-12) --}}
                    <div class="md:col-span-4 flex justify-end">
                        @if (!$session->is_current)
                            <button
                                wire:click="openDeleteModal('{{ $session->id }}')"
                                class="flex w-full  justify-center items-center px-4 py-2 text-sm font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 shadow-md transition duration-150 disabled:opacity-75 cursor-pointer"
                                wire:loading.attr="disabled"
                            >
{{--                        <span wire:loading.remove wire:target="deleteSession('{{ $session->id }}')">--}}
{{--                            --}}{{-- آیکون Lucide: Log Out --}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"--}}
{{--                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
{{--                                 stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline--}}
{{--                                    points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>--}}
{{--                        </span>--}}
                                <span wire:loading wire:target="openDeleteModal('{{ $session->id }}')">
                            {{-- اسپینر (Lucide: Loader) --}}
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16"
                                 height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"><path
                                    d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        </span>
                                <span wire:loading.remove wire:target="openDeleteModal('{{ $session->id }}')">خروج از حساب</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            {{-- پیام در صورت نبود دستگاه فعال دیگر --}}
            <div
                class="text-center p-8 bg-gray-100 dark:bg-gray-700 rounded-xl border-dashed border-2 border-gray-300 dark:border-gray-600">
                <p class="text-gray-700 dark:text-gray-300 font-semibold">تنها دستگاه فعال شما، همین دستگاه است.</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">امنیت حساب شما در وضعیت خوبی قرار دارد.</p>
            </div>
        @endforelse
    </div>
    <div x-data="{ showDeleteModal: false }"
         x-on:show-delete-modal.window="showDeleteModal = true"
         x-on:close-delete-modal.window="showDeleteModal = false" x-cloak>

        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-xl md:right-[120px] w-[370px] md:w-[440px] h-[183px] md:h-[180px] flex flex-col justify-self-start md:justify-center items-center relative">
                <p class="text-black dark:text-white">آیا مطمئن هستید که می‌خواهید این دستگاه را از حساب خود خارج کنید؟</p>
                <div class="mt-4 flex justify-end gap-2 absolute bottom-2.5 left-5">
                    <button x-on:click="showDeleteModal = false"
                            class="button-delete-custom">لغو
                    </button>
                    <button wire:click="delete"
                            class="button-delete-close-custom">حذف
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
