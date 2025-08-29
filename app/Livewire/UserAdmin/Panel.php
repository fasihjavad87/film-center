<?php

namespace App\Livewire\UserAdmin;

use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Panel extends Component
{

    public $categories;
    public $selectedCategories = [];

    // تابع mount برای بارگذاری اولیه داده‌ها
    public function mount()
    {
        $this->categories = Category::take(2)->get();
    }

    #[Layout('panel-admin.master') , Title('پنل مدیریت')]
    public function render()
    {
        return view('livewire.user-admin.panel');
    }
}
