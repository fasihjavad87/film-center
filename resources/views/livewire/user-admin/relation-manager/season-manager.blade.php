<div
    x-data="{
        showSeasonDeleteModal: false,
    }"
    {{-- Global dispatch listeners برای مودال حذف (با جلوگیری از پرش) --}}
    x-on:show-season-delete-modal.window="showSeasonDeleteModal = true; document.body.style.overflow = 'hidden';"
    x-on:close-season-delete-modal.window="showSeasonDeleteModal = false; document.body.style.overflow = 'auto';"
>
    <div class="card mt-7">
        <div class="card-body">

            <div class="flex flex-col-reverse md:flex-row md:justify-between items-start">
                <div class="search w-full md:w-[60%] mt-4 md:mt-0">
                    <label class="label-search">فصل ها</label>
                </div>
                <div class="flex gap-x-1 w-full md:w-max justify-between">
                    @if(auth()->user()->isAdmin('create-season'))
                        <a href="#" wire:click.prevent="openAddSeasonModal"
                           class="bg-green-500 text-white w-max px-3.5 py-2 rounded-lg">افزودن</a>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden"
                     wire:key="user-list-table">
                    <table class="box-table">
                        <thead class="table-head">
                        <tr>
                            <th>عنوان</th>
                            <th>شماره فصل</th>
                            <th>وضعیت</th>
                            <th>تاریخ ایجاد</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($seasons as $season)
                            <tr class="table-item">
                                <td><span class="font-normal">{{ $season->title }}</span></td>
                                <td><span class="font-normal">{{ $season->season_number }}</span></td>
                                <td>
                                <span class="{{ $season->statusClasses() }}">
                                    {{ $season->statusLabel() }}
                                </span>
                                </td>
                                <td>
                                    <span
                                        class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($season->created_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    @if(auth()->user()->isAdmin('edit-season'))
                                        <a href="{{ route('panelAdmin.seasons.edite', $season->id ) }}"
                                           class="text-green-400 hover:text-green-500">
                                            <svg class="w-22px h-22px fill-transparent">
                                                <use xlink:href="#icon-square-arrow-left-up"></use>
                                            </svg>
                                        </a>
                                    @endif
                                    @if(auth()->user()->isAdmin('edit-season'))
                                        <a wire:click.prevent="editSeason({{ $season->id }})"
                                           class="text-blue-400 hover:text-blue-500">
                                            <svg class="w-22px h-22px fill-transparent">
                                                <use xlink:href="#icon-pen-new-square"></use>
                                            </svg>
                                        </a>
                                    @endif
                                    @if(auth()->user()->isAdmin('delete-season'))
                                        <a href="#"
                                           wire:click.prevent="openDeleteModal({{ $season->id }} , '{{ $season->season_number }}')"
                                           x-on:click="$dispatch('show-season-delete-modal')"
                                           class="text-red-400 hover:text-red-500">
                                            <svg class="w-6 h-6 fill-transparent">
                                                <use xlink:href="#icon-trash-bin-minimalistic"></use>
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            {{--            <div class="flex justify-center mt-10">--}}
            {{--                <div class="flex space-x-2 rtl:space-x-reverse">--}}
            {{--                    {{ $trailers->links('vendor.pagination.custom-pagination-panel-tailwind') }}--}}
            {{--                </div>--}}
            {{--            </div>--}}

        </div>
    </div>
    <div x-data="{ openSeasonModal: false }"
         x-on:open-season-modal.window="openSeasonModal = true"
         x-on:close-season-modal.window="openSeasonModal = false" x-cloak>

        <div x-show="openSeasonModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50">
            <div class="bg-white relative dark:bg-gray-800 p-6 rounded-xl w-[822px] h-[400px] relative right-[136px]">
                <h2 class="text-xl mb-4">
                    {{ $editingSeasonId ? 'ویرایش فصل' : 'افزودن فصل جدید' }}
                </h2>
                <div class="grid grid-cols-2 gap-5">
                    <x-forms.input-field name="trailer_title" label="عنوان فصل" required wire:model="season_title"/>
                    <x-forms.input-field type="number" name="season_number" label="شماره فصل" required
                                         wire:model="season_number"/>
                    <x-forms.textarea name="season_description" label="توضیحات" required
                                      wire:model="season_description"/>
                    <x-forms.select-field
                        required
                        name="season_status"
                        label="وضعیت"
                        :options="\App\Enums\SeriesStatus::cases()"
                        wire:model.defer="season_status"
                    />

                </div>

                <div class="flex justify-end gap-2 absolute left-5 bottom-4">
                    <button x-on:click="openSeasonModal = false" class="button-close-custom">
                        انصراف
                    </button>
                    <button wire:click="saveSeason" class="button-custom">
                        {{ $editingSeasonId ? 'ویرایش' : 'ایجاد' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- مودال حذف (با کنترل اسکرول) --}}
    <div x-show="showSeasonDeleteModal" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4">

        <div x-show="showSeasonDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-2xl
                    max-w-xs w-full sm:max-w-md
                    flex flex-col transform transition-all duration-300">

            <div wire:loading wire:target="openDeleteSeasonModal"
                 class="flex justify-center items-center flex-col gap-y-1 h-full mx-auto">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div wire:loading.remove wire:target="openDeleteSeasonModal" class="w-full">
                {{-- ساختار جدید: عنوان و آیکون در یک ردیف، متن در ردیف بعدی --}}
                <div class="flex flex-col">
                    {{-- ردیف ۱: آیکون و عنوان --}}
                    <div class="flex items-center gap-x-1.5">
                        <!-- آیکون هشدار -->
                        <div class="p-2 bg-red-100 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <!-- عنوان (h3) -->
                        <h3 class="text-lg leading-6 font-bold text-red-600 dark:text-red-400">تأیید حذف فصل <span
                                class="text-indigo-600 dark:text-indigo-400">{{ $seasonNameToDelete }}</span></h3>
                    </div>

                    {{-- ردیف ۲: متن اصلی (با تورفتگی برای تراز) --}}
                    <div class="mt-3 mr-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            آیا مطمئن هستید که می‌خواهید فصل «<span
                                class="text-red-600 dark:text-red-400 font-medium">{{ $seasonNameToDelete }}</span>» را
                            برای همیشه حذف کنید؟ این عمل غیرقابل بازگشت است.
                        </p>
                    </div>
                </div>

                <!-- فوتر و دکمه‌ها (بدون absolute) -->
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <button x-on:click="showSeasonDeleteModal = false; document.body.style.overflow = 'auto';"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 cursor-pointer">
                        لغو
                    </button>
                    <button wire:click="deleteSeason"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150 shadow-md shadow-red-500/50 cursor-pointer">
                        حذف فصل
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
