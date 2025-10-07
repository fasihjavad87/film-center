<div x-data="jalaliDatePicker()">
    <div class="flex flex-col gap-2">
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700">
            {{ $label }}
        </label>

        <div class="flex space-x-2 rtl:space-x-reverse items-center justify-start">
            <select
                x-model="year"
                @change="updateDays()"
                class="block w-auto rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
            >
                <option value="">سال</option>
                <template x-for="y in years" :key="y">
                    <option :value="y" x-text="y"></option>
                </template>
            </select>

            <select
                x-model="month"
                @change="updateDays()"
                class="block w-auto rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
            >
                <option value="">ماه</option>
                <template x-for="(m, index) in months" :key="index">
                    <option :value="index + 1" x-text="m"></option>
                </template>
            </select>

            <select
                x-model="day"
                @change="updateSelectedDate()"
                class="block w-auto rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
            >
                <option value="">روز</option>
                <template x-for="d in days" :key="d">
                    <option :value="d" x-text="d"></option>
                </template>
            </select>
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" x-model="formattedDate" wire:model.live="selectedDate">
</div>
