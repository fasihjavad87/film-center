<div x-data="{ showPassword: false }" class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input :type="showPassword ? 'text' : 'password'"
               id="{{ $name }}"
               name="{{ $name }}"
               wire:model.defer="{{ $name }}"
            {{ $attributes->class([
             'mt-1 block w-full rounded-md px-2.5 py-2 font-light placeholder:text-black dark:placeholder:text-border-c text-black dark:text-white border-[1.4px] border-border-c dark:bg-gray-800 focus:border-blue-c dark:focus:border-yellow-c outline-none text-base transition-colors'
         ]) }}
            {{ $required ? 'required' : '' }}
        >

        <button type="button"
                @click="showPassword = !showPassword"
                class="absolute left-2 top-1/2 -translate-y-1/2 text-blue-c dark:text-yellow-c">
            <span x-show="!showPassword">
                <!-- آیکون چشم (مخفی) -->
                <svg class="w-5 h-5 fill-transparent">
                    <use xlink:href="#icon-eye"></use>
                </svg>
            </span>
            <span x-show="showPassword">
                <!-- آیکون چشم (نمایش) -->
                <svg class="w-5 h-5 fill-transparent">
                    <use xlink:href="#icon-eye-closed"></use>
                </svg>
            </span>
        </button>
    </div>

    @error($name)
    <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
