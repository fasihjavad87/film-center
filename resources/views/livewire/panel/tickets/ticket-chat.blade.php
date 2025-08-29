<div class="space-y-3">
    <h2 class="font-bold text-lg">تیکت: {{ $ticket->subject }}</h2>

    <div class="h-[60vh] overflow-y-auto p-4 border rounded space-y-2">
        @foreach($ticket->messages->sortBy('id') as $m)
            <div class="flex {{ $m->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] p-2 rounded-lg text-sm
                    {{ $m->sender_id === auth()->id() ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">
                    {{ $m->message }}
                    @if($m->attachments)
                        <div class="mt-1 space-y-1">
                            @foreach($m->attachments as $att)
                                <a href="{{ Storage::disk('public')->url($att['path']) }}" class="text-xs underline" target="_blank">
                                    {{ $att['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <div class="text-[10px] opacity-60 text-right mt-1">
                        {{ $m->created_at?->format('H:i - Y/m/d') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="send" class="flex items-end gap-2">
        <textarea wire:model.defer="message" class="flex-1 min-h-[44px]" placeholder="پیام خود را بنویسید…"></textarea>
        <input type="file" multiple wire:model="files"/>
        <button class="btn-primary">ارسال</button>
    </form>
</div>
