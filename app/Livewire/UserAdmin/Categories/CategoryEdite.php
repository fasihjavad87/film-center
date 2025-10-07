<?php

namespace App\Livewire\UserAdmin\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CategoryEdite extends Component
{

    public Category $category;

    public $name;
    public $e_name;
    public $slug;

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->name     = $category->name;
        $this->e_name   = $category->e_name;
        $this->slug     = $category->slug;
    }

    protected function rules()
    {
        return [
            'name'   => 'required|string|max:255',
            'e_name' => 'required|string|max:255',
            // اعتبارسنجی unique برای اسلاگ، با نادیده گرفتن اسلاگ فعلی
            'slug'   => 'required|string|max:255|unique:categories,slug,' . $this->category->id,
        ];
    }

    // متد جادویی Livewire برای به‌روزرسانی زنده
    public function updatedEname($value)
    {
        $this->slug = Str::slug($this->e_name);
    }

    public function save()
    {
        $this->validate();

        $this->category->name   = $this->name;
        $this->category->e_name = $this->e_name;
        $this->category->slug   = $this->slug;

        $this->category->save();

        session()->flash('success', 'دسته‌بندی با موفقیت ویرایش شد.');
        $this->redirect(route('panelAdmin.categories.index'));
//        return $this->redirect(route('panelAdmin.categories.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.categories.category-edite');
    }
}
