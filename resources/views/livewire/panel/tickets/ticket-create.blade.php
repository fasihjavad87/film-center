<div class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-lg font-bold mb-4">ایجاد تیکت جدید</h2>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block mb-1 text-sm">موضوع</label>
            <input type="text" wire:model="subject"
                   class="w-full border rounded p-2">
            @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm">اولویت</label>
            <select wire:model="priority" class="w-full border rounded p-2">
                <option value="low">کم</option>
                <option value="medium">متوسط</option>
                <option value="high">زیاد</option>
            </select>
            @error('priority') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm">پیام اولیه</label>
            <textarea wire:model="message" rows="4"
                      class="w-full border rounded p-2"></textarea>
            @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            ثبت تیکت
        </button>
    </form>
</div>
