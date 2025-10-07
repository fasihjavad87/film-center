<div class="space-y-6" x-data="{
        removeDiscountPercent: @entangle('remove_discount_percent'),
        toggleRemoveDiscountPercent() {
            this.removeDiscountPercent = !this.removeDiscountPercent;
            if (this.removeDiscountPercent) {
                $wire.set('discount_percent', null);
            }
        }
     }">

    <form class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:submit.prevent="save">


        <!-- نام -->
        <x-forms.input-field
            name="name"
            label="نام"
            required
            wire:model="name"
        />

        <!-- ایمیل -->
        <x-forms.input-field
            type="number"
            name="duration_days"
            label="مقدار زمان"
            required
            wire:model="duration_days"
        />


        <x-forms.input-field
            type="number"
            name="price"
            label="قیمت"
            required
            wire:model="price"
        />
        <x-forms.select-field
            required
            name="is_active"
            label="وضعیت"
            :options="\App\Enums\SubscriptionPlansStatus::cases()"
            wire:model.defer="is_active"
        />
        <x-forms.input-field
            type="number"
            name="discount_percent"
            label="مقدار تخفیف (%)"
            wire:model="discount_percent"
        />

        <x-forms.switch-field
            name="remove_discount_percent"
            label="تخفیف حذف شود؟"
            wire:model.defer="remove_discount_percent"
        />

        <x-forms.textarea
            name="description"
            label="توضیحات"
            wire:model="description"
        />


        <div class="flex justify-end items-center">
            {{--            <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>--}}
            <button type="submit"
                    class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">
                ویرایش
            </button>
        </div>
    </form>
</div>
