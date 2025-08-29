<?php

namespace App\Livewire\Admin\Tickets;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ChangeStatus extends Component
{
    public $ticketId;

    public function mount($ticketId): void
    {
        $this->ticketId = $ticketId;
    }

    public function render():View
    {
        return view('livewire.admin.tickets.change-status');
    }
}
