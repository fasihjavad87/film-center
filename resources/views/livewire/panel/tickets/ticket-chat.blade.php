<div class="space-y-3">
    <!-- هدر تیکت -->
    <div class="flex items-center justify-between gap-x-3 mb-2 px-2 py-3 border border-border-c rounded-sm">
        <div class="flex items-center gap-x-3 flex-1 overflow-hidden">
            <a href="{{ route('panelAdmin.tickets.index') }}" wire:navigate
               class="block p-3px border-[1.3px] border-blue-c/30 dark:border-yellow-c/30 rounded-md text-blue-c dark:text-yellow-c hover:bg-blue-c/10 dark:hover:bg-yellow-c/10 transition-colors">
                <svg class="w-[26px] h-[26px] fill-transparent">
                    <use xlink:href="#icon-alt-arrow-right"></use>
                </svg>
            </a>
            <h2 class="font-bold text-lg pr-3 overflow-hidden whitespace-nowrap text-ellipsis">{{ $ticket->subject }}</h2>
        </div>
        <div>
            <span class="{{ $ticket->statusClasses() }} text-[13px]">
                {{ ucfirst($ticket->statusLabel()) }}
            </span>
        </div>
    </div>

    <!-- لیست پیام‌ها -->
    <div class="h-[63vh] overflow-y-auto p-4 border border-border-c rounded space-y-2 relative"
         x-data
         x-init="$wire.on('scrollToBottom', () => { $el.scrollTop = $el.scrollHeight })">

        <div class="flex flex-col gap-y-1.5">
            @foreach($ticket->messages->sortBy('id') as $m)
                <div class="flex {{ $m->sender_id === auth()->id() ? 'justify-start' : 'justify-end' }}">
                    <div class="max-w-[50%] w-fit p-2 text-sm
                    {{ $m->sender_id === auth()->id()
                        ? 'bg-indigo-600 text-white border-radius-chat-user'
                        : 'bg-gray-200 dark:bg-gray-700 dark:text-white border-radius-chat-admin' }}">

                        <div class="font-bold text-xs mb-1">
                            {{ $m->sender->is_admin ? 'مدیر' : $m->sender->name }}
                        </div>

                        <p class="break-words whitespace-pre-wrap">{{ $m->message }}</p>

                        @if($m->attachments)
                            <div class="mt-1">
                                <a href="{{ Storage::disk('filament')->url($m->attachments) }}"
                                   class="text-xs underline  {{ $m->is_from_admin ? 'text-blue-500' : 'text-white' }} "
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

    <!-- فرم ارسال پیام -->
    <form wire:submit.prevent="send"
          x-data="{ text: @entangle('message') }"
          class="flex items-center justify-between gap-2 mt-2 border border-border-c rounded px-3 py-2 bg-gray-50 dark:bg-gray-800">

        <textarea x-model="text"
                  wire:model.defer="message"
                  class="flex-1 min-h-[44px] resize-none p-2 rounded border border-border-c dark:bg-gray-700 dark:text-white outline-hidden"
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
