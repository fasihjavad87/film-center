<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatThread extends Component
{
    use WithFileUploads;

    public int $ticketId;
    public string $message = '';
    public array $files = [];
    public int $perPage = 30;

    protected $rules = [
        'message'  => 'nullable|string|max:4000',
        'files.*'  => 'file|max:5120', // 5MB per file
    ];

    public function mount(int $ticketId): void
    {
        $this->ticketId = $ticketId;
        $this->markAsRead();
    }

    public function getTicketProperty()
    {
        return Tickets::with(['user', 'messages.sender'])->findOrFail($this->ticketId);
    }

    public function send(): void
    {
        $this->validate();

        if (blank($this->message) && empty($this->files)) return;

        $attachments = [];
        foreach ($this->files as $file) {
            $attachments[] = [
                'path' => $file->store('tickets', 'public'),
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ];
        }

        TicketMessage::create([
            'ticket_id'   => $this->ticketId,
            'sender_id'   => Auth::id(),
            'message'     => $this->message,
            'attachments' => $attachments ?: null,
        ]);

        // بروزرسانی تیکت
        Tickets::where('id', $this->ticketId)
            ->where('status', '!=', 'closed')
            ->update([
                'status' => 'answered',
                'last_reply_at' => now(),
            ]);

        $this->reset(['message', 'files']);
        $this->dispatch('message-sent');
    }

    public function markAsRead(): void
    {
        TicketMessage::where('ticket_id', $this->ticketId)
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function loadMore(): void
    {
        $this->perPage += 30;
    }

    public function render():View
    {
        return view('livewire.admin.tickets.chat-thread');
    }
}
