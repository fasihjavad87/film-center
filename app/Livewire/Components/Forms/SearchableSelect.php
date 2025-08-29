<?php

namespace App\Livewire\Components\Forms;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SearchableSelect extends Component
{
    public $search = '';
    public $selected = []; // دسته‌بندی‌های انتخاب شده
    public $categories = [];

    public function mount($selected = [])
    {
        $this->selected = $selected;
    }

    public function updatedSearch()
    {
        $this->categories = Category::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function toggleCategory($id)
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_diff($this->selected, [$id]);
        } else {
            $this->selected[] = $id;
        }
    }


    public function render(): View
    {
        return view('livewire.components.forms.searchable-select');
    }
}
