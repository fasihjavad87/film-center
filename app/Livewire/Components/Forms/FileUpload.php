<?php

namespace App\Livewire\Components\Forms;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $label;
    public $name;
    public $required = false;

    // متغیر برای فایل که با wire:model bind می‌شود
    public $preview;
    public function render():View
    {
        return view('livewire.components.forms.file-upload');
    }
}
