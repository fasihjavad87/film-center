<?php

namespace App\Livewire\UserAdmin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{

    public $name;
    public $email;

    public function mount(): void
    {
        $user = Auth::user(); // گرفتن اطلاعات کاربر لاگین شده

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    public function render()
    {
        return view('livewire.user-admin.header');
    }
}
