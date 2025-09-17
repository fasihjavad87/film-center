<?php

namespace App\Livewire\Panel\Tickets;

use App\Models\Tickets;
use App\Models\TicketMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketChat extends Component
{
    use WithFileUploads;

    public Tickets $ticket;
    public string $message = '';
    public $files;

    protected $rules = [
        'message' => 'string|max:4000',
        'files'   => 'nullable|image|mimes:png,jpg,jpeg,webp|max:700',
    ];

    public function mount($ticketId): void
    {
        $ticket = Tickets::with(['messages.sender', 'user'])->findOrFail($ticketId);

        // فقط کاربر صاحب تیکت اجازه دسترسی داشته باشه
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'شما مجاز به مشاهده این تیکت نیستید.');
        }

        $this->ticket = $ticket->load('messages.sender');
        $this->markAsRead();
    }

    // 🟢 ارسال پیام
    public function send(): void
    {
        $this->validate();

        if (blank($this->message) && empty($this->files)) {
            return;
        }

        $filePath = null;
        if ($this->files) {
            $filePath = $this->files->store('ticket_attachments', 'public');
        }

        TicketMessage::create([
            'ticket_id'  => $this->ticket->id,
            'sender_id'  => Auth::id(),
            'message'    => $this->message,
            'attachments'=> $filePath,
            'read_at'    => null,
        ]);

        $this->ticket->update([
            'status' => 'pending',
            'last_reply_at' => now(),
        ]);

        $this->reset(['message', 'files']);
        $this->ticket->load('messages.sender');

        $this->dispatch('scrollToBottom');
    }

    // 🟢 خوانده شدن پیام‌های مدیر توسط کاربر
    public function markAsRead(): void
    {
        TicketMessage::where('ticket_id', $this->ticket->id)
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    #[Layout('panel.master')]
    public function render(): View
    {
        return view('livewire.panel.tickets.ticket-chat');
    }
}
