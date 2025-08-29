<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-black dark:text-white">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->class([
             'mt-1 block w-full rounded-md px-2.5 py-2 font-light placeholder:text-black dark:placeholder:text-border-c text-black dark:text-white border-[1.4px] border-border-c dark:bg-gray-800 focus:border-blue-c dark:focus:border-yellow-c outline-none text-base cursor-pointer transition-colors'
         ]) }}
        @if($required) required @endif
    >
        <option value="">{{ $placeholder }}</option>

        @foreach($options as $value)
            @if(is_object($value) && method_exists($value, 'label'))
                {{-- enum --}}
                <option value="{{ $value->value }}">{{ $value->label() }}</option>
            @else
                {{-- array --}}
                <option value="{{ $value }}">{{ $value }}</option>
            @endif
        @endforeach

    </select>

    @error($name)
    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>
