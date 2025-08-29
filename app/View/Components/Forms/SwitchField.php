<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SwitchField extends Component
{
    public $name;
    public $label;
    public $value;
    public bool $required;

    public function __construct($name, $label = null, $value = false , bool $required = false,)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.switch-field');
    }
}
