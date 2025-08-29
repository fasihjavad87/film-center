<div x-data="{ isUploading: false, progress: 0, filename: '' }"
     x-on:livewire-upload-start="isUploading = true; progress = 0"
     x-on:livewire-upload-finish="isUploading = false; progress = 100"
     x-on:livewire-upload-error="isUploading = false"
     x-on:livewire-upload-progress="progress = $event.detail.progress"
     class="mb-4">

    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-black dark:text-white mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="flex flex-col border-[1.4px] border-border-c dark:bg-gray-800 rounded-md py-2 px-2.5 gap-3 cursor-pointer" @click="$refs.fileInput.click()">
        <input
            type="file"
            id="{{ $name }}"
            wire:model="{{ $name }}"
            x-ref="fileInput"
            @change="filename = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
            class="hidden"
            {{ $required ? 'required' : '' }}
        >
        <div class="flex relative">
            <div class="flex items-center gap-x-3.5">

                <div>
                    @if($avatar)
                        <img src="{{ is_string($avatar) ? asset('storage/' . $avatar) : $avatar->temporaryUrl() }}"
                             alt="Preview" class="h-10 w-10 rounded-full">
                    @else
                        <div class="flex justify-center items-center h-10 w-10 rounded-full border-[1.4px]">
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
                        <span x-text="filename" class="cursor-pointer select-none" @click="$refs.fileInput.click()"></span>
                    </div>
                    <button  type="button" class="text-red-500 hover:text-red-700 absolute top-0 -left-1 bg-red-300/25 flex py-1 px-0.5 rounded-sm cursor-pointer select-none"
                            @click="$refs.fileInput.value = ''; filename=''; $wire.set('{{ $name }}', null)">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
            </div>

        </div>
        <div>
            <div class="flex justify-center items-center gap-x-1.5" x-cloak>
                <div class="w-[94%] bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-blue-c dark:bg-yellow-c h-2.5 rounded-full transition-all duration-300"
                         :style="`width: ${progress}%`"></div>
                </div>
                <span class="text-xs text-blue-c dark:text-yellow-c select-none" x-text="`${progress}%`"></span>
            </div>
        </div>
    </div>

    @error($name)
    <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
