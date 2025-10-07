<?php

namespace App\Livewire\UserAdmin\Countries;


use App\Models\Countries;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CountryCreate extends Component
{

    public $name_en;
    public $name_fa;
    public $code;

    protected $rules = [
        'name_en' => 'required|string|max:255|unique:countries,name_en',
        'name_fa' => 'required|string|max:255|unique:countries,name_fa',
        'code' => 'required|string|max:255|unique:countries,code',
    ];

    public function save()
    {
        $this->validate();

        Countries::create([
            'name_en' => $this->name_en,
            'name_fa' => $this->name_fa,
            'code' => $this->code,
        ]);

        return redirect()->route('panelAdmin.countries.index');
//        return $this->redirect(route('panelAdmin.countries.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.countries.country-create');
    }
}
