<?php

namespace App\Livewire\UserAdmin\Tickets;

use App\Models\TicketMessage;
use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketChat extends Component
{
    use WithFileUploads;

    public Tickets $ticket; // تیکت فعلی
    public string $message = '';
    public $files;
    public int $perPage = 30; // تعداد پیام‌ها


    protected $rules = [
        'message' => 'string|max:4000',
        'files.*' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:700',
    ];

    // 🟢 گرفتن تیکت بر اساس ID
    public function mount($ticketId): void
    {
        $ticket = Tickets::with(['messages.sender', 'user'])->findOrFail($ticketId);

        // بررسی اینکه کاربر ادمین باشه
        if (!Auth::user()->is_admin) {
            abort(403, 'شما ادمین نیستید.');
        }

        // بررسی اینکه این تیکت به ادمین فعلی اختصاص داده شده یا نه
        if ($ticket->assigned_to !== null && $ticket->assigned_to !== Auth::id()) {
            abort(403, 'این تیکت به شما ارجاع داده نشده است.');
        }

        $this->ticket = $ticket->load('messages.sender');
        $this->markAsRead();
    }

    // 🟢 تغییر وضعیت تیکت
    public function updateStatus($status): void
    {
        $this->ticket->update(['status' => $status]);
        $this->ticket->refresh();
    }

    // 🟢 ارسال پیام
    public function send(): void
    {
        $this->validate();

        if (blank($this->message) && empty($this->files)) {
            return;
        }

        $fileName = null;
        if ($this->files) {
            $fileName = $this->files->store('tickets_attachments', 'filament'); // این مسیر کامل رو برمی‌گردونه
        }
//        $attachments = [];
//        if ($this->files) { // یک فایل وجود دارد
//            $attachments[] = [
//                'path' => $this->files->store('tickets_attachments', 'filament'),
//                'name' => $this->files->getClientOriginalName(),
//                'size' => $this->files->getSize(),
//                'mime' => $this->files->getMimeType(),
//            ];
//        }
        TicketMessage::create([
            'ticket_id' => $this->ticket->id,
            'sender_id' => Auth::id(),
            'message' => $this->message,
            // فقط path یا name ذخیره کن
            'attachments' => $fileName,
            'read_at' => null,
        ]);

//        TicketMessage::create([
//            'ticket_id' => $this->ticket->id,
//            'sender_id' => Auth::id(),
//            'message' => $this->message,
//            'attachments' => !empty($attachments) ? $attachments : null,
//            'read_at' => null,
//        ]);

        $this->ticket->update([
            'status' => 'answered',
            'last_reply_at' => now(),
            'assigned_to' => Auth::id(),
        ]);

        $this->reset(['message', 'files']);
        $this->ticket->load('messages.sender');
        $this->dispatch('scrollToBottom');
    }

    // 🟢 خوانده شدن پیام‌ها
    public function markAsRead(): void
    {
        TicketMessage::where('ticket_id', $this->ticket->id)
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    #[Layout('panel-admin.master')]
    public function render(): View
    {
        return view('livewire.user-admin.tickets.ticket-chat');
    }
}
