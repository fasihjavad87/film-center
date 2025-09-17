<div class="">
    <form wire:submit.prevent="save" class="space-y-6">

        {{-- اطلاعات فیلم --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.input-field
                    name="title"
                    label="عنوان"
                    placeholder="جومانجی"
                    required
                    wire:model="title"
                />
            </div>

            <div>
                <x-forms.input-field
                    name="e_name"
                    label="نام انگلیسی"
                    placeholder="jomangi"
                    required
                    wire:model.live.debounce.300ms="e_name"
                />
            </div>

            <div>
                <x-forms.input-field
                    name="slug"
                    label="نشانی"
                    required
                    wire:model="slug"
                />
            </div>

            <div>
                <x-forms.select-field
                    required
                    name="status"
                    label="وضعیت"
                    :options="\App\Enums\MoviesStatus::cases()"
                    wire:model.defer="status"
                />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.textarea
                    name="description"
                    label="توضیحات"
                    required
                    wire:model="description"
                />
            </div>

            <div>
                <x-forms.input-field
                    type="number"
                    name="runtime"
                    label="مدت زمان (دقیقه)"
                    required
                    wire:model="runtime"
                />
            </div>
        </div>
        {{-- دسته بندی و کشور --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <livewire:components.forms.searchable-select
                    required
                    label="دسته بندی ها"
                    :model="$allCategories"
                    t_name="name"
                    name="categories"
                    wire:model="categories"
                    t_id="id"
                />
                @error('categories') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <livewire:components.forms.searchable-select
                    required
                    label="کشور ها"
                    :model="$allCountries"
                    t_name="name_fa"
                    t_id="id"
                    name="countries"
                    wire:model="countries"
                />
                @error('countries') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex flex-col gap-y-2">
            <label>نوع منبع</label>
            <div class="flex gap-x-2.5">
                <x-forms.radio
                    label="لینک"
                    name="source_type"
                    wire:model.live="source_type"
                    value="url"
                />
                <x-forms.radio
                    label="آپلود فایل"
                    name="source_type"
                    wire:model.live="source_type"
                    value="file"
                />
            </div>

            @if($source_type === 'url')
                <div>
                    <x-forms.input-field
                        name="movie_url"
                        label="لینک فیلم"
                        required
                        wire:model="movie_url"
                    />
                </div>
            @elseif($source_type === 'file')
                <div>
                    <div x-data="{ isUploading: false, progress: 0, filename: '' }"
                         x-on:livewire-upload-start="isUploading = true; progress = 0"
                         x-on:livewire-upload-finish="isUploading = false; progress = 100"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress"
                         class="mb-4">


                        <label for="avatar" class="block text-sm font-medium text-black dark:text-white mb-1">
                            تصویر پروفایل
                            <span class="text-red-500">*</span>
                        </label>

                        <div
                            class="flex flex-col border-[1.4px] border-border-c dark:bg-gray-800 rounded-md py-2 px-2.5 gap-3 cursor-pointer"
                            @click="$refs.fileInput.click()">
                            <input
                                type="file"
                                id="movie_file"
                                wire:model="movie_file"
                                x-ref="fileInput"
                                @change="filename = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
                                class="hidden"
                            >
                            <div class="flex relative">
                                <div class="flex items-center gap-x-3.5">

                                    <div>
                                        @if($movie_file)
                                            <img
                                                src="{{ is_string($movie_file) ? asset('storage/' . $movie_file) : $movie_file->temporaryUrl() }}"
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
                                                @click="$refs.fileInput.value = ''; filename=''; $wire.set('movie_file', null)">
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

                        @error('movie_file')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        </div>

        {{-- اطلاعات تکمیلی --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.input-field
                    name="imdb_id"
                    label="IMDb ID"
                    required
                    wire:model="imdb_id"
                />
            </div>

            <div>
                <x-forms.input-field
                    type="number"
                    name="imdb_rating"
                    min="0"
                    step="0.1"
                    max="10"
                    label="امتیاز IMDB"
                    required
                    wire:model="imdb_rating"
                />
            </div>

            <div>
                <livewire:components.forms.searchable-select
                    required
                    label="سال انتشار"
                    :multiple="false"
                    :model="$years"
                    t_name="year"
                    t_id="year"
                    name="release_year"
                    wire:model="release_year"
                />
                @error('release_year') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-forms.input-field
                    name="language"
                    label="زبان"
                    required
                    wire:model="language"
                />
            </div>

            <div>
                <x-forms.input-field
                    name="age_rating"
                    label="رده سنی"
                    required
                    wire:model="age_rating"
                />
            </div>

            <div>
                <div x-data="{ isUploading1: false, progress1: 0, filename1: '' }"
                     x-on:livewire-upload-start="isUploading1 = true; progress1 = 0"
                     x-on:livewire-upload-finish="isUploading1 = false; progress1 = 100"
                     x-on:livewire-upload-error="isUploading1 = false"
                     x-on:livewire-upload-progress="progress1 = $event.detail.progress"
                     class="mb-4">


                    <label for="avatar" class="block text-sm font-medium text-black dark:text-white mb-1">
                        پوستر
                        <span class="text-red-500">*</span>
                    </label>

                    <div
                        class="flex flex-col border-[1.4px] border-border-c dark:bg-gray-800 rounded-md py-2 px-2.5 gap-3 cursor-pointer"
                        @click="$refs.fileInput.click()">
                        <input
                            type="file"
                            id="poster"
                            wire:model="poster"
                            x-ref="fileInput"
                            @change="filename1 = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
                            class="hidden"
                        >
                        <div class="flex relative">
                            <div class="flex items-center gap-x-3.5">

                                <div>
                                    @if($poster instanceof \Illuminate\Http\UploadedFile)
                                        <img src="{{ $poster->temporaryUrl() }}" alt="Preview"
                                             class="h-10 w-10 rounded-full">
                                    @elseif($currentPoster)
                                        <img src="{{ asset('uploads/' . $currentPoster) }}" alt="Preview"
                                             class="h-10 w-10 rounded-full">
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
                        <span x-show="!filename1" class="cursor-pointer select-none"
                              @click="$refs.fileInput.click()">انتخاب فایل</span>
                                        <span x-text="filename1" class="cursor-pointer select-none"
                                              @click="$refs.fileInput.click()"></span>
                                    </div>
                                    <button type="button"
                                            class="text-red-500 hover:text-red-700 absolute top-0 -left-1 bg-red-300/25 flex py-1 px-0.5 rounded-sm cursor-pointer select-none"
                                            @click="$refs.fileInput.value = ''; filename1=''; $wire.set('poster', null)">
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
                                        :style="`width: ${progress1}%`"></div>
                                </div>
                                <span class="text-xs text-blue-c dark:text-yellow-c select-none"
                                      x-text="`${progress1}%`"></span>
                            </div>
                        </div>
                    </div>

                    @error('poster')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>
{{--        <button type="submit"--}}
{{--                class="button-custom">--}}
{{--            ذخیره--}}
{{--        </button>--}}
    </form>
    <livewire:user-admin.relation-manager.trailer-manager :trailerable-id="$movie->id" trailerable-type="Movie" />

</div>
