<div class="space-y-6">

    <form class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:submit.prevent="save">

        <x-forms.input-field
            name="name"
            label="نام"
            placeholder="کمدی"
            required
            wire:model="name"
        />

        <x-forms.input-field
            name="e_name"
            label="نام انگلیسی"
            placeholder="comedy"
            required
            wire:model.live.debounce.300ms="e_name"
        />

        <x-forms.input-field
            name="slug"
            label="نشانی"
            required
            wire:model="slug"
        />

        <div class="flex justify-end items-center md:col-span-2">
            <button type="submit"
                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">
                ایجاد دسته‌بندی
            </button>
        </div>
    </form>
</div>
