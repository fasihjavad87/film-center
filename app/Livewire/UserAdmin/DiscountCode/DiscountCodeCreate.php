<?php

namespace App\Livewire\UserAdmin\DiscountCode;


use App\Models\DiscountCode;
use App\Models\SubscriptionPlans;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DiscountCodeCreate extends Component
{

    public $code , $percent , $is_active , $max_usage , $expires_at;
    public $selectedPlans = [] ;

    public function save()
    {
        $this->validate([
            'code' => 'required|string',
            'percent' => 'required|integer',
            'is_active' => 'required|in:active,inactive',
            'max_usage' => 'integer|nullable',
            'expires_at' => 'required|date',
            'selectedPlans' => 'array|nullable',
        ]);

        if ($this->expires_at) {
            // ورودی مثلا: 1404/7/2
            $this->expires_at = Verta::parse($this->expires_at)->toCarbon()->format('Y-m-d');
        }

//        dd([
//            'code'       => $this->code,
//            'percent'       => $this->percent,
//            'is_active'   => $this->is_active,
//            'max_usage'       => $this->max_usage,
//            'expires_at'       => $this->expires_at,
//            'selectedPlans'       => $this->selectedPlans,
//        ]);


        $discount_code = DiscountCode::create([
            'code' => $this->code,
            'percent' => $this->percent,
            'is_active' => $this->is_active,
            'max_usage' => $this->max_usage,
            'expires_at' => $this->expires_at,
        ]);

        $discount_code->plans()->sync($this->selectedPlans);
//
//
        return redirect()->route('panelAdmin.discountCodes.index');
//        return $this->redirect(route('panelAdmin.discountCodes.index'), navigate: true);

    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.discount-code.discount-code-create', [
            'allPlans' => SubscriptionPlans::all(),
        ]);
    }
}
