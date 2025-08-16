<?php

namespace App\Livewire\Panel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Panel extends Component
{


    #[Layout('panel.master') , Title('پنل مدیریت')]
    public function render():View
    {
        return view('livewire.panel.panel');
    }
}
