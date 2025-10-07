<?php

namespace App\Livewire\UserAdmin\Countries;

use App\Models\Countries;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CountryList extends Component
{

    use WithPagination;

    public $search = '';
    public $countryIdToDelete = null;
    public $countryNameToDelete = '';



    public function openDeleteModal($countryId , $countryName)
    {
        $this->countryIdToDelete = $countryId;
        $this->countryNameToDelete = $countryName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $country = Countries::find($this->countryIdToDelete);
        if ($country) {
            $country->delete();

            $this->dispatch('toast-notification', [
                'message' => 'کشور حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->countryIdToDelete = null;
        $this->countryNameToDelete = '';
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {

        $countries = Countries::query()
            ->when($this->search, function ($query) {
                $query->where('name_en', 'like', '%' . $this->search . '%')
                    ->orWhere('name_fa', 'like', '%' . $this->search . '%');
            })->paginate(10);
        return view('livewire.user-admin.countries.country-list', [
            'countries' => $countries,
        ]);
    }
}
