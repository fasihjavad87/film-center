<?php

namespace App\Livewire\UserAdmin\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{

    use WithPagination;

    public $search = '';
//    public $showDeleteModal = false;
    public $categoryIdToDelete = null;



//    public function openDeleteModal($categoryId)
//    {
//        $this->showDeleteModal = true;
//        $this->categoryIdToDelete = $categoryId;
//    }
//    public function closeDeleteModal()
//    {
//        $this->showDeleteModal = false;
//        $this->categoryIdToDelete = null;
//    }
//    public function delete()
//    {
//        // منطق حذف
//        $category = Category::find($this->categoryIdToDelete);
//        if ($category) {
//            $category->delete();
//
//            $this->dispatch('toast-notification', [
//                'message' => 'دسته بندی حذف شد.',
//                'duration' => 5000
//            ]);
//        }
//        $this->closeDeleteModal();
//        $this->resetPage();
//    }

    public function openDeleteModal($categoryId)
    {
        $this->categoryIdToDelete = $categoryId;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $category = Category::find($this->categoryIdToDelete);
        if ($category) {
            $category->delete();

            $this->dispatch('toast-notification', [
                'message' => 'دسته بندی حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('e_name', 'like', '%' . $this->search . '%');
            })->paginate(10);
        return view('livewire.user-admin.categories.category-list', [
            'categories' => $categories,
        ]);
    }
}
