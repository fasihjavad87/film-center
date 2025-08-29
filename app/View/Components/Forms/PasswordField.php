<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordField extends Component
{
    public string $name;
    public ?string $label;
    public bool $required;

    public function __construct(string $name, string $label = null, bool $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.password-field');
    }
}
