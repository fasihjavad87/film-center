<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.input-field
                    name="code"
                    label="کد تخفیف"
                    required
                    wire:model="code"
                />
                @error('code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-forms.input-field
                    type="number"
                    name="percent"
                    label="درصد تخفیف"
                    required
                    wire:model="percent"
                />
                @error('percent') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-forms.select-field
                    required
                    name="is_active"
                    label="وضعیت"
                    :options="\App\Enums\DiscountCodeStatus::cases()"
                    wire:model.defer="is_active"
                />
                @error('is_active') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-forms.input-field
                    type="number"
                    name="max_usage"
                    label="تعداد کاربران"
                    wire:model="max_usage"
                />
                @error('max_usage') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>

                <livewire:components.forms.searchable-select
                    label="اشتراک ها"
                    :model="$allPlans"
                    t_name="name"
                    t_id="id"
                    name="selectedPlans"
                    wire:model="selectedPlans"
                />
                @error('selectedPlans') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-forms.input-field
                    name="expires_at"
                    label="تاریخ انقضا ( 1404/7/2 )"
                    required
                    wire:model="expires_at"
                />
                @error('expires_at') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

        </div>

        <button type="submit"
                class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">
            ویرایش
        </button>
    </form>

</div>
