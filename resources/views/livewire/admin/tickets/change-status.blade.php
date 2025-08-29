<div class="space-y-2">
    <label class="block text-sm font-medium ">
        وضعیت تیکت
    </label>
    <select wire:model="status" class="w-full border rounded px-2 py-1 dark:bg-gray-800 dark:text-white">
        <option value="open">باز</option>
        <option value="pending">درحال بررسی</option>
        <option value="answered">پاسخ داده‌شده</option>
        <option value="closed">بسته</option>
    </select>

    <x-filament::button wire:click="updateStatus" class="mt-2 w-full">
        تغییر وضعیت
    </x-filament::button>
</div>
