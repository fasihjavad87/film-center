<div class="flex radio-wrapper">
    <input type="radio"
           id="{{ $name }}-{{ $value }}"
           name="{{ $name }}"
           value="{{ $value }}"
           wire:model.live="{{ $name }}"
        {{ $checked ? 'checked' : '' }}
    >
    <label for="{{ $name }}-{{ $value }}">{{ $label }}</label>
</div>
