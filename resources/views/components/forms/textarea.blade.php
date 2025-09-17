<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-black dark:text-white">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea id="{{ $name }}"
              name="{{ $name }}"
              placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->class([
            'mt-1 block h-[120px] resize-y w-full rounded-md px-2.5 py-2 font-light placeholder:text-black dark:placeholder:text-border-c text-black dark:text-white border-[1.4px] border-border-c dark:bg-gray-800 focus:border-blue-c dark:focus:border-yellow-c outline-none text-base transition-colors'
        ]) }}>

        </textarea>

    @error($name)
    <span class="text-red-500 text-sm mt-1 ">{{ $message }}</span>
    @enderror
</div>
