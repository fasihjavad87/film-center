<?php

namespace App\Livewire\Components\Forms;

use Livewire\Component;

class CustomDatePicker extends Component
{

    public $name;
    public $label;
    public $selectedDate = '';

    public function mount($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }


    public function render()
    {
        return view('livewire.components.forms.custom-date-picker');
    }
}
