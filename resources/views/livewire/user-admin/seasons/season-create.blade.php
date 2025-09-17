<div>
    <form wire:submit.prevent="save" class="space-y-6">

        {{-- اطلاعات فیلم --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <livewire:components.forms.searchable-select
                    required
                    :multiple="false"
                    label="سریال ها"
                    :model="$series"
                    t_name="title"
                    t_id="id"
                    name="series_id"
                    wire:model="series_id"
                />
                @error('series_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-forms.input-field
                    name="title"
                    label="عنوان فصل"
                    required
                    wire:model="title"
                />
            </div>
            <div>
                <x-forms.input-field
                    type="number"
                    name="season_number"
                    label="شماره فصل"
                    required
                    wire:model="season_number"
                />
            </div>
            <div>
                <x-forms.select-field
                    required
                    name="status"
                    label="وضعیت"
                    :options="\App\Enums\SeriesStatus::cases()"
                    wire:model.defer="status"
                />
            </div>
            <div>
                <x-forms.textarea
                    name="description"
                    label="توضیحات"
                    required
                    wire:model="description"
                />
            </div>

        </div>


        <a href="#" wire:click.prevent="save" class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">ذخیره</a>
{{--        <button type="submit"--}}
{{--                class="w-max h-max px-18px py-2.5 bg-blue-c hover:bg-blue-c/80 text-white dark:bg-yellow-c dark:hover:bg-yellow-c/80 dark:text-black rounded-md outline-none cursor-pointer">--}}
{{--            ذخیره--}}
{{--        </button>--}}
    </form>
</div>
