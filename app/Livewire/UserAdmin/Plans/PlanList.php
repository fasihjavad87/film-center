<?php

namespace App\Livewire\UserAdmin\Plans;

use App\Models\SubscriptionPlans;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PlanList extends Component
{

    use WithPagination;

    public $search = '';
    public $planIdToDelete = null;
    public $planNameToDelete = '';



    public function openDeleteModal($planId , $planName)
    {
        $this->planIdToDelete = $planId;
        $this->planNameToDelete = $planName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $plan = SubscriptionPlans::find($this->planIdToDelete);
        if ($plan) {
            $plan->delete();

            $this->dispatch('toast-notification', [
                'message' => 'اشتراک حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->planIdToDelete = null;
        $this->planNameToDelete = '';
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $plans = SubscriptionPlans::query()
            ->with('discountCodes')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('duration_days', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.user-admin.plans.plan-list' , ['plans' => $plans]);
    }
}
