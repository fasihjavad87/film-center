<div class="space-y-6">

    <form class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:submit.prevent="save">

        <x-forms.input-field
            name="name_en"
            label="نام انگلیسی"
            placeholder="Iran"
            required
            wire:model="name_en"
        />

        <x-forms.input-field
            name="name_fa"
            label="نام فارسی"
            placeholder="ایران"
            required
            wire:model="name_fa"
        />

        <x-forms.input-field
            name="code"
            label="کد کشور"
            placeholder="IR"
            required
            wire:model="code"
        />

        <div class="flex justify-end items-center md:col-span-2">
{{--            <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ایجاد کشور</a>--}}
            <button type="submit"
                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">
                ذخیره
            </button>
        </div>
    </form>
</div>
