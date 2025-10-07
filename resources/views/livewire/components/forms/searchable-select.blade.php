<div class="mb-4" wire:ignore>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-black dark:text-white">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif


    <div class="custom-select-wrapper mt-1" data-model="{{ $name }}">
        <select id="my-select" @if($multiple) multiple @endif  style="display: none;">
            @if(!$multiple)
                <option value="" @if(empty($value)) selected @endif>-- انتخاب کنید --</option>
            @endif
            @foreach($model as $item)
                @php
                    $val = is_object($item) ? $item->{$t_id} : $item;
                    $text = is_object($item) ? $item->{$t_name} : $item;
                @endphp
                <option value="{{ $val }}"
                        @if($multiple)
                            @if(collect($value)->contains($val)) selected @endif
                        @else
                            @if($value == $val) selected @endif
                    @endif
                >
                    {{ $text }}
                </option>
            @endforeach
        </select>

        <div class="custom-select-ui">
            <div class="selected-tags-container">
                <input type="text" id="search-input" class="search-input" placeholder="">
            </div>

            <div class="toggle-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m7 15 5 5 5-5"/>
                    <path d="m7 9 5-5 5 5"/>
                </svg>
            </div>
        </div>

        <div class="options-container">
        </div>
    </div>

    @error($name)
    <span class="text-red-500 text-sm mt-1 ">{{ $message }}</span>
    @enderror
</div>
