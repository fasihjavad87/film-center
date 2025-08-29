<div class="mb-4"
     x-data="{ isUploading: false, progress: 0 }"
     x-on:livewire-upload-start="isUploading = true; progress = 0"
     x-on:livewire-upload-finish="isUploading = false; progress = 100"
     x-on:livewire-upload-error="isUploading = false"
     x-on:livewire-upload-progress="progress = $event.detail.progress">

    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input type="file"
           id="{{ $name }}"
           wire:model="{{ $name }}"
           class="block w-full text-sm text-gray-500 dark:text-gray-400
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-lg file:border-0
                  file:text-sm file:font-semibold
                  file:bg-primary-50 file:text-primary-700
                  dark:file:bg-primary-800 dark:file:text-primary-200
                  hover:file:bg-primary-100 dark:hover:file:bg-primary-700"
        {{ $required ? 'required' : '' }}>

    <!-- Progress Bar -->
    <div x-show="isUploading" class="mt-2">
        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
            <div class="bg-primary-600 h-2.5 rounded-full transition-all duration-300"
                 :style="`width: ${progress}%`"></div>
        </div>
        <span class="text-xs text-gray-500 dark:text-gray-400" x-text="`در حال آپلود: ${progress}%`"></span>
    </div>

    @error($name)
    <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror

    <!-- Preview -->
        @if($avatar)
            <div class="mt-2">
                <img src="{{ is_string($avatar) ? asset('storage/' . $avatar) : $avatar->temporaryUrl() }}"
                     alt="Preview" class="h-24 object-contain border rounded-lg">
            </div>
        @endif
</div>
