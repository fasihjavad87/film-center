<x-filament::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- ستون چت --}}
        <div class="lg:col-span-2">
            @livewire('admin.tickets.chat-thread', ['ticketId' => $record->id], key('chat-'.$record->id))
        </div>

        {{-- ستون اطلاعات تیکت / تغییر وضعیت --}}
        <div class="lg:col-span-1 space-y-4">
            <x-filament::section heading="اطلاعات تیکت">
                <div class="space-y-2 text-sm">
                    <div><b>کاربر:</b> {{ $record->user->name }}</div>
                    <div><b>موضوع:</b> {{ $record->subject }}</div>
                    <div><b>وضعیت:</b> {{ $record->status }}</div>
                    <div><b>اولویت:</b> {{ $record->priority }}</div>
                    <div><b>آخرین پاسخ:</b> {{ $record->last_reply_at?->format('Y/m/d H:i') ?? '—' }}</div>
                </div>
            </x-filament::section>

            <x-filament::section heading="تغییر وضعیت">
                @livewire('admin.tickets.change-status', ['ticketId' => $record->id], key('status-'.$record->id))
            </x-filament::section>
        </div>
    </div>
</x-filament::page>
