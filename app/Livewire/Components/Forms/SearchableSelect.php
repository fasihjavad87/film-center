<?php

namespace App\Livewire\Components\Forms;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SearchableSelect extends Component
{
    #[Modelable] // باید این ویژگی (attribute) را اضافه کنید
    public $value;
    public $label;
    public $model;
    public $name;
    public $required = false;
    public $t_name;
    public $t_id;

    public $multiple = true;

    public function updated($name, $value)
    {
        if ($name === $this->name) {
            $this->value = $value;
        }
    }

    public function render(): View
    {
        return view('livewire.components.forms.searchable-select');
    }
}
