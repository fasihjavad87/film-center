<?php

namespace App\Livewire\Panel\Tickets;

use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class TicketsList extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function setFilter($status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function getTicketsProperty()
    {
        $query = Tickets::with('lastMessage')
            ->where('user_id', Auth::id())
            ->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return $query->paginate(10);
    }
    #[Layout('panel.master') , Title('پنل مدیریت')]
    public function render(): View
    {
        return view('livewire.panel.tickets.tickets-list', [
            'tickets' => $this->tickets,
        ]);
    }
}
