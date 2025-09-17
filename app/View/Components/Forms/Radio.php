<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{

    public $label;
    public $name;
    public $value;
    public $checked;

    public function __construct(
        $name,
        $label = null,
        $value = null,
        $checked = false,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.radio');
    }
}
