<?php

namespace App\Livewire\UserAdmin\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CategoryCreate extends Component
{

    public $name;
    public $e_name;
    public $slug;

    protected $rules = [
        'name' => 'required|string|max:255',
        'e_name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
    ];

    // این متد رو به کامپوننت Livewire اضافه کن
    public function updatedEname($value)
    {
        $this->slug = Str::slug($this->e_name);
    }

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'e_name' => $this->e_name,
            'slug' => $this->slug,
        ]);

//        return redirect()->route('panelAdmin.categories.index');
        return $this->redirect(route('panelAdmin.categories.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.categories.category-create');
    }
}
