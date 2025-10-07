<?php

namespace App\Livewire\UserAdmin\Plans;

use App\Models\Season;
use App\Models\SubscriptionPlans;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PlanEdite extends Component
{

    public $plan;
    public $name , $duration_days , $price , $discount_percent , $description , $is_active ;
    public $remove_discount_percent = false;


    public function mount(SubscriptionPlans $plan)
    {
        $this->plan = $plan;
        $this->name = $plan->name;
        $this->duration_days = $plan->duration_days;
        $this->price = $plan->price;
        $this->discount_percent = $plan->discount_percent;
        $this->description = $plan->description;
        $this->is_active = $plan->is_active;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'duration_days' => 'integer|required',
        'price' => 'required|integer',
        'discount_percent' => 'integer|nullable',
        'description' => 'nullable',
        'is_active' => 'required|in:active,inactive',
    ];

    public function save()
    {
        $this->validate();

        if ($this->remove_discount_percent) {
            $this->discount_percent = null;
        }

        $this->plan->update([
            'name' => $this->name,
            'duration_days' => $this->duration_days,
            'price' => $this->price,
            'discount_percent' => $this->discount_percent,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route("panelAdmin.plans.index");
//        return $this->redirect(route('panelAdmin.plans.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {

        return view('livewire.user-admin.plans.plan-edite');
    }
}
