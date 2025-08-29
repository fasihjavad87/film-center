<?php

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ToastNotification extends Component
{

    public $message;
    public $duration = 3000;

    public function render():View
    {
        return view('livewire.components.toast-notification');
    }
}
