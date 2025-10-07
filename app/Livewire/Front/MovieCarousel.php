<?php

namespace App\Livewire\Front;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class MovieCarousel extends Component
{
    public function render():View
    {
        return view('livewire.front.movie-carousel');
    }
}
