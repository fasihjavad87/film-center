<div class="space-y-6">

    <form class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:submit.prevent="save">

        <!-- نام -->
        <x-forms.input-field
            name="name"
            label="نام"
            placeholder="نام دسته‌بندی"
            required
            wire:model="name"
        />

        <!-- نام انگلیسی -->
        <x-forms.input-field
            name="e_name"
            label="نام انگلیسی"
            placeholder="Category Name"
            required
            wire:model.live.debounce.500ms="e_name"
        />

        <!-- Slug -->
        <x-forms.input-field
            name="slug"
            label="Slug"
            placeholder="category-name"
            required
            wire:model="slug"
        />

        <div class="flex justify-end items-center md:col-span-2">
        <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>
{{--            <button type="submit"--}}
{{--                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">--}}
{{--                ویرایش دسته‌بندی--}}
{{--            </button>--}}
        </div>
    </form>
</div>
