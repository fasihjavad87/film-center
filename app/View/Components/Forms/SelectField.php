<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectField extends Component
{
    public string $name;
    public ?string $label;
    public array|\BackedEnum $options;
    public string $placeholder;
    public bool $required;

    public function __construct(
        string $name,
        string $label = null,
        array $options = [],
        string $placeholder = 'یک گزینه انتخاب کنید',
        bool $required = false,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select-field');
    }
}
