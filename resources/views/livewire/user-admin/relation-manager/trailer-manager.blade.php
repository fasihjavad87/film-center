<div
    x-data="{
        showDeleteModal: false,
    }"
    {{-- Global dispatch listeners برای مودال حذف (با جلوگیری از پرش) --}}
    x-on:show-delete-modal.window="showDeleteModal = true; document.body.style.overflow = 'hidden';"
    x-on:close-delete-modal.window="showDeleteModal = false; document.body.style.overflow = 'auto';"
>
    <div class="card mt-7">
        <div class="card-body">

            <div class="flex flex-col-reverse md:flex-row md:justify-between items-start">
                <div class="search w-full md:w-[60%] mt-4 md:mt-0">
                    <label class="label-search">تیزر ها</label>
                </div>
                <div class="flex gap-x-1 w-full md:w-max justify-between">
                    @if(auth()->user()->isAdmin('create-trailer'))
                        <a href="#" wire:click.prevent="openAddModal"
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
                            <th>ترتیب نمایش</th>
                            <th>مقدار زمان</th>
                            <th>تاریخ ایجاد</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trailers as $trailer)
                            <tr class="table-item">
                                <td><span class="font-normal">{{ $trailer->title }}</span></td>
                                <td><span class="font-normal">{{ $trailer->order }}</span></td>
                                <td><span class="font-normal">{{ $trailer->duration }}</span></td>
                                <td>
                                    <span
                                        class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($trailer->created_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    @if(auth()->user()->isAdmin('edit-trailer'))
                                        <a wire:click.prevent="editTrailer({{ $trailer->id }})"
                                           class="text-blue-400 hover:text-blue-500">
                                            <svg class="w-22px h-22px fill-transparent">
                                                <use xlink:href="#icon-pen-new-square"></use>
                                            </svg>
                                        </a>
                                    @endif
                                    @if(auth()->user()->isAdmin('delete-trailer'))
                                        <a href="#"
                                           wire:click.prevent="openDeleteModal({{ $trailer->id }} , '{{ $trailer->order }}')"
                                           x-on:click="$dispatch('show-delete-modal')"
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
    <div x-data="{ openTrailerModal: false }"
         x-on:open-trailer-modal.window="openTrailerModal = true"
         x-on:close-trailer-modal.window="openTrailerModal = false" x-cloak>

        <div x-show="openTrailerModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50">
            <div class="bg-white relative dark:bg-gray-800 p-6 rounded-xl w-[822px] h-[400px] relative right-[136px]">
                <h2 class="text-xl mb-4">
                    {{ $editingTrailerId ? 'ویرایش تیزر' : 'افزودن تیزر جدید' }}
                </h2>
                <div class="grid grid-cols-2 gap-5">
                    <x-forms.input-field name="trailer_title" label="عنوان تیزر" required wire:model="trailer_title"/>
                    <x-forms.input-field type="number" name="trailer_duration" label="مدت زمان (دقیقه)" required
                                         wire:model="trailer_duration"/>
                    <x-forms.input-field type="number" name="trailer_order" label="ترتیب نمایش" required
                                         wire:model="trailer_order"/>

                    <div>
                        <label>نوع منبع</label>
                        <div class="flex gap-x-2.5">
                            <x-forms.radio
                                label="لینک"
                                name="source_type_trailer"
                                wire:model.live="source_type_trailer"
                                value="trailer-url"
                            />
                            <x-forms.radio
                                label="آپلود فایل"
                                name="source_type_trailer"
                                wire:model.live="source_type_trailer"
                                value="trailer-file"
                            />
                        </div>
                    </div>

                    @if($source_type_trailer === 'trailer-url')
                        <div>
                            <x-forms.input-field
                                name="video_url"
                                label="لینک تیزر"
                                required
                                wire:model="trailer_url"
                            />
                        </div>
                    @elseif($source_type_trailer === 'trailer-file')
                        <div>
                            <div x-data="{ isUploading: false, progress: 0, filename: '' }"
                                 x-on:livewire-upload-start="isUploading = true; progress = 0"
                                 x-on:livewire-upload-finish="isUploading = false; progress = 100"
                                 x-on:livewire-upload-error="isUploading = false"
                                 x-on:livewire-upload-progress="progress = $event.detail.progress"
                                 class="mb-4">


                                <label for="avatar"
                                       class="block text-sm font-medium text-black dark:text-white mb-1">
                                    تصویر پروفایل
                                    <span class="text-red-500">*</span>
                                </label>

                                <div
                                    class="flex flex-col border-[1.4px] border-border-c dark:bg-gray-800 rounded-md py-2 px-2.5 gap-3 cursor-pointer"
                                    @click="$refs.fileInput.click()">
                                    <input
                                        type="file"
                                        id="trailer_file"
                                        wire:model="trailer_file"
                                        x-ref="fileInput"
                                        @change="filename = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
                                        class="hidden"
                                    >
                                    <div class="flex relative">
                                        <div class="flex items-center gap-x-3.5">

                                            <div>
                                                @if($trailer_file)
                                                    <img
                                                        src="{{ is_string($trailer_file) ? asset('storage/' . $trailer_file) : $trailer_file->temporaryUrl() }}"
                                                        alt="Preview" class="h-10 w-10 rounded-full">
                                                @else
                                                    <div
                                                        class="flex justify-center items-center h-10 w-10 rounded-full border-[1.4px]">
                                                        <svg class="w-6 h-6 fill-transparent">
                                                            <use xlink:href="#icon-image"></use>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="">
                        <span x-show="!filename" class="cursor-pointer select-none"
                              @click="$refs.fileInput.click()">انتخاب فایل</span>
                                                    <span x-text="filename" class="cursor-pointer select-none"
                                                          @click="$refs.fileInput.click()"></span>
                                                </div>
                                                <button type="button"
                                                        class="text-red-500 hover:text-red-700 absolute top-0 -left-1 bg-red-300/25 flex py-1 px-0.5 rounded-sm cursor-pointer select-none"
                                                        @click="$refs.fileInput.value = ''; filename=''; $wire.set('trailer_file', null)">
                                                    <i class="fa-light fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    <div>
                                        <div class="flex justify-center items-center gap-x-1.5" x-cloak>
                                            <div class="w-[94%] bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                <div
                                                    class="bg-blue-c dark:bg-yellow-c h-2.5 rounded-full transition-all duration-300"
                                                    :style="`width: ${progress}%`"></div>
                                            </div>
                                            <span class="text-xs text-blue-c dark:text-yellow-c select-none"
                                                  x-text="`${progress}%`"></span>
                                        </div>
                                    </div>
                                </div>

                                @error('trailer_file')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-2 absolute left-5 bottom-4">
                    <button x-on:click="openTrailerModal = false" class="button-close-custom">
                        انصراف
                    </button>
                    <button wire:click="saveTrailer" class="button-custom">
                        {{ $editingTrailerId ? 'ویرایش' : 'ایجاد' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- مودال حذف (با کنترل اسکرول) --}}
    <div x-show="showDeleteModal" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4">

        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-2xl
                    max-w-xs w-full sm:max-w-md
                    flex flex-col transform transition-all duration-300">

            <div wire:loading wire:target="openDeleteModal"
                 class="flex justify-center items-center flex-col gap-y-1 h-full mx-auto">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div wire:loading.remove wire:target="openDeleteModal" class="w-full">
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
                        <h3 class="text-lg leading-6 font-bold text-red-600 dark:text-red-400">تأیید حذف تیزر <span
                                class="text-indigo-600 dark:text-indigo-400">{{ $trailerNameToDelete }}</span></h3>
                    </div>

                    {{-- ردیف ۲: متن اصلی (با تورفتگی برای تراز) --}}
                    <div class="mt-3 mr-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            آیا مطمئن هستید که می‌خواهید تیزر «<span
                                class="text-red-600 dark:text-red-400 font-medium">{{ $trailerNameToDelete }}</span>» را
                            برای همیشه حذف کنید؟ این عمل غیرقابل بازگشت است.
                        </p>
                    </div>
                </div>

                <!-- فوتر و دکمه‌ها (بدون absolute) -->
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <button x-on:click="showDeleteModal = false; document.body.style.overflow = 'auto';"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 cursor-pointer">
                        لغو
                    </button>
                    <button wire:click="delete"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150 shadow-md shadow-red-500/50 cursor-pointer">
                        حذف تیزر
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
