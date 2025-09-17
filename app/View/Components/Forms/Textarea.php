<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;
    public $label;
    public $placeholder;
    public $required;
    public $extraClass;
public function __construct(
    $name,
    $label = null,
    $placeholder = '',
    $required = false,
    $extraClass = ''
) {
    $this->name = $name;
    $this->label = $label;
    $this->placeholder = $placeholder;
    $this->required = $required;
    $this->extraClass = $extraClass;
}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.textarea');
    }
}
