<?php

namespace App\Livewire\Panel\Plans;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\SubscriptionPlans;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Shetabit\Multipay\Invoice;
//use Shetabit\Payment\Facade\Payment;

class PlanList extends Component
{

    public function initiatePayment( $plan_id)
    {
        $user = Auth::user();
        $plan = SubscriptionPlans::query()->where('id', $plan_id)->first();
        $amount = (int) $plan->finalPrice();


        DB::beginTransaction();
        try {
//            dd($amount);
            $ref = generate_unique_ref('PAY-');

            $payment = Payment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'ref_id'  => $ref,
                'discount'  => $plan->effectiveDiscountPercent(),
                'gateway' => 'zarinpal', // یا نام درگاه
                'amount'  => $amount,
                'status'  => PaymentStatus::Pending->value,
            ]);

            DB::commit();


            $result = \Shetabit\Payment\Facade\Payment::purchase(
                (new Invoice)->amount($amount),
                function($driver, $transactionId) use ($payment) {
                    $payment->update(['transaction_id' => $transactionId]);
                }
            )->pay()->toJson();
//            dd(json_decode($result));
            return $this->redirect(json_decode($result)->action);

        } catch (\Exception $e) {
            DB::rollBack();
            // لاگ خطا و نمایش پیام مناسب
            \Log::error('Payment initiation failed: '.$e->getMessage(), ['plan'=>$plan_id, 'user'=> $user->id]);
//            $this->dispatchBrowserEvent('toast', ['type'=>'error','text'=>'خطا در اتصال به درگاه.']);
        }

    }

    #[Layout('panel.master')]
    public function render():View
    {
        $plans = SubscriptionPlans::query()
            // فقط پلن‌های فعال را نمایش می‌دهیم
            ->where('is_active', 'active')
            // کدهای تخفیف را eager load می‌کنیم
            ->with('discountCodes')
            ->get();
        return view('livewire.panel.plans.plan-list' , ['plans' => $plans]);
    }
}
