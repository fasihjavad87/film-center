<?php

namespace App\Livewire\Panel\Tickets;


use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TicketCreate extends Component
{
    public $subject;
    public $priority = 'medium'; // مقدار پیش‌فرض
    public $message;

    protected $rules = [
        'subject' => 'required|string|max:255',
        'priority' => 'required|string|in:low,medium,high',
        'message' => 'required|string|min:5',
    ];

    public function submit()
    {
        $this->validate();

        $ticket = Tickets::create([
            'user_id'  => Auth::id(),
            'subject'  => $this->subject,
            'priority' => $this->priority,
            'status'   => 'open',
        ]);

        $ticket->messages()->create([
            'sender_id' => Auth::id(),
            'message'   => $this->message,
        ]);

        return redirect()->route('panel.tickets.show', $ticket->id)
            ->with('success', 'تیکت با موفقیت ایجاد شد.');
    }

    #[Layout('panel.master')]
    public function render():View
    {
        return view('livewire.panel.tickets.ticket-create');
    }
}
