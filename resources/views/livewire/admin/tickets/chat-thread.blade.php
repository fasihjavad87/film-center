<div
    x-data="{
        autoscroll() {
            this.$nextTick(() => {
                const box = this.$refs.box;
                if (!box) return;
                box.scrollTop = box.scrollHeight;
            });
        }
    }"
    x-init="autoscroll(); $wire.on('message-sent', () => autoscroll())"
    wire:poll.5s="markAsRead" {{-- هر ۵ ثانیه پیام‌های خوانده نشده آپدیت می‌شوند --}}
    class="space-y-3"
>
    {{-- لیست پیام‌ها --}}
    <div x-ref="box" class="h-[70vh] overflow-y-auto rounded-lg p-4 bg-white dark:bg-gray-800 border">
        @foreach($this->ticket->messages->sortBy('id') as $m)
            <div class="mb-2 flex {{ $m->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] px-3 py-2 rounded-2xl text-sm
                    {{ $m->sender_id === auth()->id()
                        ? 'bg-primary-600 text-white'
                        : 'bg-gray-200 text-gray-900 dark:bg-gray-700 dark:text-white' }}">

                    {{-- متن پیام --}}
                    @if($m->message)
                        <div class="whitespace-pre-line">{{ $m->message }}</div>
                    @endif

                    {{-- ضمیمه‌ها --}}
                    @if($m->attachments)
                        <div class="mt-2 space-y-1">
                            @foreach($m->attachments as $att)
                                <a class="text-xs underline" href="{{ Storage::disk('public')->url($att['path']) }}" target="_blank">
                                    {{ $att['name'] ?? 'Attachment' }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- زمان و وضعیت خوانده شدن --}}
                    <div class="mt-1 opacity-60 text-[10px] text-right ltr:ml-2 rtl:mr-2">
                        {{ $m->created_at?->format('H:i - Y/m/d') }}
                        @if($m->sender_id !== auth()->id() && $m->read_at)
                            • خوانده شد
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- فرم ارسال پیام --}}
    <form wire:submit.prevent="send" class="flex items-end gap-2">
        <x-filament::input.wrapper class="flex-1">
            <textarea
                style="color: #000000"
                wire:model.defer="message"
                rows="2"
                placeholder="پیام خود را بنویسید…"
                class="w-full min-h-[44px] resize-y custom-tailwindcss-filament-chat"
            ></textarea>
        </x-filament::input.wrapper>

        <div>
            <input type="file" multiple wire:model="files" class="block text-xs"/>
            @error('files.*') <div class="text-danger-600 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <x-filament::button type="submit">ارسال</x-filament::button>
    </form>
</div>
