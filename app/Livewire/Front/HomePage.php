<?php

namespace App\Livewire\Front;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{
    #[Layout('front.master')]
    public function render():View
    {
        return view('livewire.front.home-page');
    }
}
