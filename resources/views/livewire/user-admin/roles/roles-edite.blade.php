<div class="space-y-6">

    <form class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:submit.prevent="save">

        <!-- نام -->
        <x-forms.input-field
            name="name"
            label="نام نقش"
            required
            wire:model="name"
        />
        <livewire:components.forms.searchable-select
            required
            label="مجوز ها"
            :model="$allPermissions"
            t_name="name"
            name="selectedPermissions"
            wire:model="selectedPermissions"
            t_id="name"
        />
        @error('selectedPermissions') <span class="text-red-500">{{ $message }}</span> @enderror


        <div class="flex justify-end items-center md:col-span-2">
            {{--            <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>--}}
            <button type="submit"
                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">
                ویرایش
            </button>
        </div>
    </form>
</div>
