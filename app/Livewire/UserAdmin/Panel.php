<?php

namespace App\Livewire\UserAdmin;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Panel extends Component
{

//    public $categories;
//    public $selectedCategories = [];

    // تابع mount برای بارگذاری اولیه داده‌ها
//    public function mount()
//    {
//        $this->categories = Category::all();
//    }

    #[Layout('panel-admin.master') , Title('پنل مدیریت')]
    public function render():View
    {
        return view('livewire.user-admin.panel');
    }
}
