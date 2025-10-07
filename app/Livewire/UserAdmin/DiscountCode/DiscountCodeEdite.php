<?php

namespace App\Livewire\UserAdmin\DiscountCode;

use App\Models\DiscountCode;
use App\Models\SubscriptionPlans;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DiscountCodeEdite extends Component
{

    public $discount_code;
    public $code , $percent , $is_active , $max_usage , $expires_at;
    public $selectedPlans = [] ;


    public function mount(DiscountCode $discountCode)
    {
        $this->discount_code = $discountCode ;
        $this->code = $discountCode->code;
        $this->percent = $discountCode->percent;
        $this->is_active = $discountCode->is_active;
        $this->max_usage = $discountCode->max_usage;
//        $this->expires_at = $discountCode->expires_at;
        if ($discountCode->expires_at) {
            // 1. تاریخ میلادی (Carbon Object) را به Verta بده.
            $v = Verta::instance($discountCode->expires_at);

            // 2. آن را به فرمت شمسی مورد نظر شما (مثلاً YYYY/MM/DD) تبدیل کن.
            // متد format('Y/m/d') تاریخ شمسی را بدون زمان برمی‌گرداند.
            $this->expires_at = $v->format('Y/m/d');
        } else {
            $this->expires_at = null;
        }
        $this->selectedPlans = $discountCode->plans->pluck('id')->toArray();
    }

    protected $rules = [
        'code' => 'required|string',
        'percent' => 'required|integer',
        'is_active' => 'required|in:active,inactive',
        'max_usage' => 'integer|nullable',
        'expires_at' => 'required|date',
        'selectedPlans' => 'array|nullable',
    ];

    public function save()
    {
        $this->validate();

        if ($this->expires_at) {
            // ورودی مثلا: 1404/7/2
            $this->expires_at = Verta::parse($this->expires_at)->toCarbon()->format('Y-m-d');
        }

//        dd([
//            'is_active' => $this->is_active,
//        ]);

        $this->discount_code->update([
            'code' => $this->code,
            'percent' => $this->percent,
            'is_active' => $this->is_active,
            'max_usage' => $this->max_usage,
            'expires_at' => $this->expires_at,
        ]);
        $this->discount_code->plans()->sync($this->selectedPlans);

        return redirect()->route("panelAdmin.discountCodes.index");
//        return $this->redirect(route('panelAdmin.discountCodes.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.discount-code.discount-code-edite' , [
            'allPlans' => SubscriptionPlans::all(),
        ]);
    }
}
