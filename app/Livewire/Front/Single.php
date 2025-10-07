<?php

namespace App\Livewire\Front;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Single extends Component
{
    public function render():View
    {
        return view('livewire.front.single');
    }
}
