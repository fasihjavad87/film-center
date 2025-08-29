<div class="flex flex-col gap-y-3">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700 dark:text-white">
            {{ $label }}
        </label>
    @endif

    <label class="relative inline-flex w-12 h-6 cursor-pointer">
        <input type="checkbox" wire:model="{{ $name }}" class="peer sr-only">
        <span class="w-full h-6 bg-gray-300 rounded-full peer-checked:bg-blue-c dark:peer-checked:bg-yellow-c transition-colors"></span>
        <span class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-transform peer-checked:translate-x-6"></span>
    </label>

    @error($name)
    <span class="text-red-500 text-xs ml-2">{{ $message }}</span>
    @enderror
</div>
