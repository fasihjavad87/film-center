<?php

namespace App\Livewire\UserAdmin\DiscountCode;

use App\Models\DiscountCode;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class DiscountCodeList extends Component
{

    use WithPagination;

    public $search = '';
    public $discountCodeIdToDelete = null;
    public $discountCodeNameToDelete = '';



    public function openDeleteModal($discountCodeId , $discountCodeName)
    {
        $this->discountCodeIdToDelete = $discountCodeId;
        $this->discountCodeNameToDelete = $discountCodeName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $discountCode = DiscountCode::find($this->discountCodeIdToDelete);
        if ($discountCode) {
            $discountCode->delete();

            $this->dispatch('toast-notification', [
                'message' => 'تخفیف حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->discountCodeIdToDelete = null;
        $this->discountCodeNameToDelete = '';
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        $discountCodes = DiscountCode::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.user-admin.discount-code.discount-code-list' , ['discountCodes' => $discountCodes]);
    }
}
