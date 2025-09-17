<?php

namespace App\Livewire\UserAdmin\Countries;

use App\Models\Category;
use App\Models\Countries;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CountryEdite extends Component
{

    public Countries $country;

    public $name_en;
    public $name_fa;
    public $code;

    public function mount(Countries $country): void
    {
        $this->country = $country;
        $this->name_en     = $country->name_en;
        $this->name_fa   = $country->name_fa;
        $this->code     = $country->code;
    }

    protected function rules()
    {
        return [
            'name_en'   => 'required|string|max:255|unique:countries,name_en,' . $this->country->id,
            'name_fa' => 'required|string|max:255|unique:countries,name_fa,' . $this->country->id,
            'code'   => 'required|string|max:255|unique:countries,code,' . $this->country->id,
        ];
    }


    public function save()
    {
        $this->validate();

        $this->country->name_en   = $this->name_en;
        $this->country->name_fa = $this->name_fa;
        $this->country->code   = $this->code;

        $this->country->save();

        session()->flash('success', 'کشور با موفقیت ویرایش شد.');
//        $this->redirect(route('panelAdmin.countries.index'));
        return $this->redirect(route('panelAdmin.countries.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.countries.country-edite');
    }
}
