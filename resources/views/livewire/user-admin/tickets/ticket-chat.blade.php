<div class="space-y-3">
    <div>
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-x-3 mb-2 px-2 py-3 border border-border-c rounded-sm">
            <!-- 🟢 این div در موبایل به صورت عمودی و در دسکتاپ به صورت افقی چیده می‌شود -->
            <div class="flex items-center gap-x-3 flex-1 overflow-hidden">
                <div class="flex items-center gap-x-1.5 flex-shrink-0">
                    <img src="{{ asset('uploads/' . $ticket->user->avatar) }}"
                         class="w-9 h-9 rounded-full border" alt="avatar">
                    <div class="font-bold text-sm">{{ $ticket->user->name }}</div>
                </div>

                <!-- 🟢 عنوان تیکت: در موبایل با سه نقطه کوتاه می‌شود و در دسکتاپ کامل نمایش داده می‌شود -->
                <h2 class="font-bold text-lg pr-3 overflow-hidden whitespace-nowrap text-ellipsis border-r-[1.4px] border-border-c flex-1 min-w-0 md:pr-0 md:border-r-0 md:whitespace-normal md:text-wrap">{{ $ticket->subject }}</h2>
            </div>

            <!-- 🟢 در حالت موبایل این div به صورت flex عمل میکند -->
            <div class="flex gap-x-1.5 mt-2 md:mt-0 md:flex-shrink-0 items-center justify-between">
                <div class="flex items-center gap-x-1.5">
        <span class="{{ $ticket->statusClasses() }} text-[13px]">
            {{ ucfirst($ticket->statusLabel()) }}
        </span>
                    <span class="{{ $ticket->statusPriorityClasses() }} text-[13px]">
            {{ ucfirst($ticket->statusPriorityLabel()) }}
        </span>
                </div>
                <!-- 🟢 دکمه بازگشت در کنار status ها قرار گرفته است -->
                <a href="{{ route('panelAdmin.tickets.index') }}"
                   class="block p-3px border-[1.3px] border-blue-c/30 dark:border-yellow-c/30 rounded-md text-blue-c dark:text-yellow-c hover:bg-blue-c/10 dark:hover:bg-yellow-c/10 transition-colors">
                    <svg class="w-[26px] h-[26px] fill-transparent">
                        <use xlink:href="#icon-alt-arrow-left"></use>
                    </svg>
                </a>
            </div>

        </div>


        <!-- 🟢 اطلاعات کاربر -->
        <div class="h-[63vh] overflow-y-auto p-4 border border-border-c rounded space-y-2 relative">

            <!-- فاصله برای هدر -->
            <div class="flex flex-col gap-y-1.5">
                @foreach($ticket->messages->sortBy('id') as $m)
                    <div class="flex {{ $m->is_from_admin ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[50%] w-fit p-2 text-sm
                            {{ $m->is_from_admin ? 'bg-indigo-600 text-white border-radius-chat-admin'
                                                 : 'bg-gray-200 dark:bg-gray-700 dark:text-white border-radius-chat-user' }}">
                            <div class="font-bold text-xs mb-1">
                                {{ $m->sender->is_admin ? 'مدیر' : $m->sender->name }}
                            </div>
                            <p class="break-words whitespace-pre-wrap">{{ $m->message }}</p>

                            @if($m->attachments)
                                <div class="mt-1">
                                    <a href="{{ Storage::disk('filament')->url($m->attachments) }}"
                                       class="text-xs underline {{ $m->is_from_admin ? 'text-white' : 'text-blue-500' }}"
                                       target="_blank">
                                        ضمیمه
                                    </a>
                                </div>
                            @endif


                            <div class="text-[10px] opacity-60 text-right mt-1">
                                {{ \Hekmatinasser\Verta\Verta::instance($m->created_at)->format('Y/n/j H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- فرم ارسال -->
        <form wire:submit.prevent="send"
              x-data="{ text: @entangle('message') }"
              class="flex items-center justify-between gap-2 mt-2 border border-border-c rounded px-3 py-2 bg-gray-50 dark:bg-gray-800">

            <textarea x-model="text"
                      wire:model.defer="message"
                      class="w-[680px] min-h-[44px] resize-none p-2 rounded border border-border-c dark:bg-gray-700 dark:text-white outline-hidden"
                      placeholder="پیام خود را بنویسید…"></textarea>

            <div class="flex items-center gap-x-1.5">
                <label
                    class="cursor-pointer text-sm bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 flex items-center justify-center overflow-hidden {{ $files ? 'w-10 h-10 p-0' : 'px-2 py-2 w-10 h-10' }}">

                    @if($files)
                        <img src="{{ is_string($files) ? asset('storage/' . $files) : $files->temporaryUrl() }}"
                             alt="Preview"
                             class="w-full h-full rounded-none">
                    @else
                        <svg class="w-[26px] h-[26px] fill-transparent">
                            <use xlink:href="#icon-paperclip"></use>
                        </svg>
                    @endif

                    <input type="file" wire:model="files" class="hidden"/>
                </label>

                <button type="submit"
                        :disabled="!text.trim().length"
                        :class="!text.trim().length
                        ? 'text-gray-500 cursor-not-allowed '
                        : 'bg-indigo-600 text-white hover:bg-indigo-700 cursor-pointer'"
                        class="px-3 py-3 rounded transition bg-gray-300">
                    <svg class="w-[26px] h-[26px] fill-transparent">
                        <use xlink:href="#icon-plain"></use>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- تغییر وضعیت -->
    <div class="mt-4">
        <label for="status" class="block text-sm font-medium mb-1">وضعیت تیکت:</label>
        <select id="status" wire:change="updateStatus($event.target.value)"
                class="border rounded px-2 py-1 dark:bg-gray-700 dark:text-white">
            <option value="open" @selected($ticket->status === 'open')>باز</option>
            <option value="answered" @selected($ticket->status === 'answered')>پاسخ داده‌شده</option>
            <option value="pending" @selected($ticket->status === 'pending')>در انتظار پاسخ</option>
            <option value="closed" @selected($ticket->status === 'closed')>بسته شده</option>
        </select>
    </div>
</div>
