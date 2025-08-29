<?php

namespace App\Livewire\Panel\Tickets;

use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class TicketChat extends Component
{
    use WithFileUploads;

    public Tickets $ticket;
    public string $message = '';
    public array $files = [];
    public int $perPage = 30;

    protected $rules = [
        'message' => 'nullable|string|max:4000',
        'files.*' => 'file|max:5120',
    ];

    public function mount(Tickets $ticket): void
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403); // کاربر اجازه نداره تیکت دیگران رو ببینه
        }

        $this->ticket = $ticket->load('messages');
        $this->markAsRead();
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
            'ticket_id' => $this->ticket->id,
            'sender_id' => Auth::id(),
            'message' => $this->message,
            'attachments' => $attachments ?: null,
        ]);

        $this->ticket->update(['status' => 'pending', 'last_reply_at' => now()]);

        $this->reset(['message','files']);

        $this->ticket->load('messages');
    }

    public function markAsRead(): void
    {
        TicketMessage::where('ticket_id', $this->ticket->id)
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    #[Layout('panel.master')]
    public function render():View
    {
        return view('livewire.panel.tickets.ticket-chat');
    }
}
