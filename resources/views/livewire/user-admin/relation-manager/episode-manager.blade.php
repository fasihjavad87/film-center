<div>
    <div class="card mt-7">
        <div class="card-body">

            <div class="flex flex-col-reverse md:flex-row md:justify-between items-start">
                <div class="search w-full md:w-[60%] mt-4 md:mt-0">
                    <label class="label-search">قسمت ها</label>
                </div>
                <div class="flex gap-x-1 w-full md:w-max justify-between">
                    <a href="#" wire:click.prevent="openAddModal"
                       class="bg-green-500 text-white w-max px-3.5 py-2 rounded-lg">افزودن</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="parent-table w-max md:w-full overflow-auto md:overflow-hidden"
                     wire:key="user-list-table">
                    <table class="box-table">
                        <thead class="table-head">
                        <tr>
                            <th>نام سریال</th>
                            <th>شماره فصل</th>
                            <th>شماره قسمت</th>
                            <th>عنوان</th>
                            <th>مقدار زمان</th>
                            <th>تاریخ ایجاد</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($episodes as $episode)
                            <tr class="table-item">
                                <td><span class="font-normal">{{ $episode->season->series->title }}</span></td>
                                <td><span class="font-normal">{{ $episode->season->title }}</span></td>
                                <td><span class="font-normal">{{ $episode->episode_number }}</span></td>
                                <td><span class="font-normal">{{ $episode->title }}</span></td>
                                <td><span class="font-normal">{{ $episode->runtime }}</span></td>
                                <td>
                                    <span
                                        class="font-normal">{{ \Hekmatinasser\Verta\Verta::instance($episode->created_at)->format('Y/m/d') }}</span>
                                </td>
                                <td class="flex justify-center items-end gap-x-2.5">
                                    <a wire:click.prevent="editTrailer({{ $episode->id }})"
                                       class="text-blue-400 hover:text-blue-500">
                                        <svg class="w-22px h-22px fill-transparent">
                                            <use xlink:href="#icon-pen-new-square"></use>
                                        </svg>
                                    </a>
                                    <a href="#" wire:click.prevent="openDeleteModal({{ $episode->id }})"
                                       class="text-red-400 hover:text-red-500">
                                        <svg class="w-6 h-6 fill-transparent">
                                            <use xlink:href="#icon-trash-bin-minimalistic"></use>
                                        </svg>
                                    </a>

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
    <div x-data="{ openEpisodeModal: false }"
         x-on:open-episode-modal.window="openEpisodeModal = true"
         x-on:close-episode-modal.window="openEpisodeModal = false" x-cloak>

        <div x-show="openEpisodeModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-75"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="fixed inset-0 flex items-center justify-center bg-black/50">
            <div class="bg-white relative dark:bg-gray-800 p-6 rounded-xl w-[822px] h-[400px] relative right-[136px]">
                <h2 class="text-xl mb-4">
                    {{ $editingEpisodeId ? 'ویرایش قسمت' : 'افزودن قسمت جدید' }}
                </h2>
                <div class="grid grid-cols-2 gap-5">
                    <x-forms.input-field name="trailer_title" label="عنوان قسمت" required wire:model="episode_title"/>
                    <x-forms.input-field type="number" name="episode_number" label="شماره قسمت" required
                                         wire:model="episode_number"/>
                    <x-forms.input-field type="number" name="episode_runtime" label="مدت زمان (دقیقه)" required
                                         wire:model="episode_runtime"/>

                    <div>
                        <label>نوع منبع</label>
                        <div class="flex gap-x-2.5">
                            <x-forms.radio
                                label="لینک"
                                name="source_type_episode"
                                wire:model.live="source_type_episode"
                                value="episode-url"
                            />
                            <x-forms.radio
                                label="آپلود فایل"
                                name="source_type_episode"
                                wire:model.live="source_type_episode"
                                value="episode-file"
                            />
                        </div>
                    </div>

                    @if($source_type_episode === 'episode-url')
                        <div>
                            <x-forms.input-field
                                name="episode_url"
                                label="لینک قسمت"
                                required
                                wire:model="episode_url"
                            />
                        </div>
                    @elseif($source_type_episode === 'episode-file')
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
                                        id="episode_file"
                                        wire:model="episode_file"
                                        x-ref="fileInput"
                                        @change="filename = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
                                        class="hidden"
                                    >
                                    <div class="flex relative">
                                        <div class="flex items-center gap-x-3.5">

                                            <div>
                                                @if($episode_file)
                                                    <img
                                                        src="{{ is_string($episode_file) ? asset('storage/' . $episode_file) : $episode_file->temporaryUrl() }}"
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
                                                        @click="$refs.fileInput.value = ''; filename=''; $wire.set('episode_file', null)">
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

                                @error('episode_file')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-2 absolute left-5 bottom-4">
                    <button x-on:click="openEpisodeModal = false" class="button-close-custom">
                        انصراف
                    </button>
                    <button wire:click="saveEpisode" class="button-custom">
                        {{ $editingEpisodeId ? 'ویرایش' : 'ایجاد' }}
                    </button>
                </div>
            </div>
        </div>
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

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl md:right-[120px] w-[270px] md:w-[440px] h-[183px] md:h-[180px] flex flex-col justify-self-start md:justify-center items-center relative">
                <p class="text-black dark:text-white">آیا مطمئن هستید که می‌خواهید این قسمت را حذف کنید؟</p>
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
