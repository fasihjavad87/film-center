<div class="space-y-3">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">تیکت‌ها</h2>
        <a href="{{ route('panel.tickets.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + ایجاد تیکت جدید
        </a>
    </div>
    @forelse( $tickets as $ticket )
        <a href="{{ route('panel.tickets.show', $ticket->id) }}"
           class="block p-3 border rounded hover:bg-gray-100 dark:hover:bg-gray-700">
            <div class="flex justify-between">
                <span>{{ $ticket->subject }}</span>
                <span class="text-sm text-gray-500">{{ $ticket->status }}</span>
            </div>
            @if($ticket->lastMessage)
                <div class="text-xs text-gray-400 mt-1">
                    آخرین پیام: {{ Str::limit($ticket->lastMessage->message, 50) }}
                </div>
            @endif
        </a>
    @empty
        <p>تیکتی وجود ندارد.</p>
    @endforelse
</div>
