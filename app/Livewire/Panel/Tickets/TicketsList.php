<?php

namespace App\Livewire\Panel\Tickets;

use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TicketsList extends Component
{
    public $tickets;

    public function mount(): void
    {
        $this->tickets = Tickets::where('user_id', Auth::id())
            ->with('lastMessage')
            ->latest()
            ->get();
    }
    #[Layout('panel.master') , Title('پنل مدیریت')]
    public function render(): View
    {
        return view('livewire.panel.tickets.tickets-list');
    }
}
