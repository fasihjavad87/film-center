<?php

namespace App\Livewire\UserAdmin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $name;
    public $email;
    public $avatar;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->avatar = $user->avatar;
        }
    }

    public function render()
    {
        return view('livewire.user-admin.sidebar');
    }
}
