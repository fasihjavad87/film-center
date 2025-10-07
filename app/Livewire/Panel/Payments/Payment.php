<?php

namespace App\Livewire\Panel\Payments;

use App\Enums\PaymentStatus;
use App\Models\UserSubscriptions;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use App\Models\Payment as PaymentModel; // 🟢 نام مستعار برای مدل Payment (رفع تداخل)

// 🔴 کلاس را به PaymentCallback تغییر می دهیم تا با مدل تداخل نداشته باشد
class Payment extends Component
{

    // این متغیرها مستقیماً از پارامترهای URL دریافت می شوند (Livewire 3)
    #[Url]
    public $Authority; // Ref ID برگشتی از درگاه (مثل S0000000000000000000000000000000nrmp)

    #[Url]
    public $Status; // وضعیت پرداخت (مثلاً OK)

    public $payment;
    public $isSuccessful = false;
    public $message = 'در حال بررسی وضعیت پرداخت...';

    /**
     * متد mount() زمانی اجرا می شود که کامپوننت بارگذاری می شود.
     */
    public function mount(): void
    {
        // 1. چک کردن پارامترهای اصلی
        if (!$this->Authority || !$this->Status) {
            $this->message = 'خطا: پارامترهای بازگشتی از درگاه ناقص هستند.';
            $this->isSuccessful = false;
            return;
        }

        // ۱. یافتن رکورد پرداخت بر اساس کد پیگیری داخلی (Ref ID)
        $this->payment = PaymentModel::query()
            ->with('plan')
            ->where('transaction_id', $this->Authority)
            ->first();

        // اگر رکورد پرداخت پیدا نشد
        if (!$this->payment) {
            $this->message = 'خطا: سابقه تراکنش با کد پیگیری ' . $this->Authority . ' یافت نشد.';
            $this->isSuccessful = false;
            return;
        }

        // اگر وضعیت پرداخت قبلا موفق شده باشد، سریعاً نتیجه موفق را نشان می دهیم
        if ($this->payment->status === PaymentStatus::Paid->value) {
            $this->message = 'این تراکنش قبلاً با موفقیت تایید و پردازش شده است.';
            $this->isSuccessful = true;
            return;
        }

        // 🔴 منطق جدید: فقط Status=='OK' به handleSuccess می رود.
        // اگر Status غیر از OK باشد، به عنوان لغو توسط کاربر در نظر گرفته می شود.
        if ($this->Status === 'OK') {
            $this->handleSuccess();
        }
        else {
            // درگاه هایی مانند زرین پال این حالت را برای لغو توسط کاربر برمی گردانند.
            $this->handleFailure(PaymentStatus::Canceled);
        }
    }

    /**
     * اجرای عملیات تایید نهایی و فعال سازی اشتراک
     */
    protected function handleSuccess(): void
    {
        DB::beginTransaction();
        try {

            $transactionId = $this->payment->transaction_id ?? $this->Authority;
            // 🟢 ۱. مرحله حیاتی: اعتبارسنجی نهایی پرداخت از درگاه
            ShetabitPayment::amount($this->payment->amount)
                ->transactionId($transactionId)
                ->verify();

            // 🟢 ۲. به‌روزرسانی وضعیت رکورد Payment
            $this->payment->update([
                'status' => PaymentStatus::Paid->value,
            ]);
//            dd($this->payment->status);

            // 🟢 ۳. فعال‌سازی اشتراک کاربر
            $this->activateSubscription($this->payment);

            DB::commit();

            $this->isSuccessful = true;
            $this->message = 'پرداخت با موفقیت انجام شد و اشتراک شما فعال گردید.';

        } catch (InvalidPaymentException $exception) {
            // 🔴 اگر verify fail شود
            DB::rollBack();
            $this->handleFailure(PaymentStatus::Failed); // وضعیت را Failed می کنیم

            Log::error('Payment Verification Failed: ' . $exception->getMessage(), ['authority' => $this->Authority]);

            // 🔴 پیام خطا را اینجا تنظیم می کنیم (این پیام در view نمایش داده خواهد شد)
            $this->message = 'تأیید پرداخت توسط درگاه با خطا مواجه شد. (کد خطا: ' . $exception->getCode() . '). مبلغ به حساب شما برمی‌گردد.';

        } catch (\Exception $e) {
            // خطاهای سیستمی دیگر
            DB::rollBack();
            $this->handleFailure(PaymentStatus::Failed);
            Log::error('Subscription Activation Failed: ' . $e->getMessage(), ['authority' => $this->Authority]);
            $this->message = 'خطای سیستمی در فعال‌سازی اشتراک رخ داد. لطفاً با پشتیبانی تماس بگیرید.';
        }
    }

    /**
     * ثبت رکورد اشتراک جدید برای کاربر
     * @param PaymentModel $payment
     */
    protected function activateSubscription(PaymentModel $payment): void
    {
        $existing = UserSubscriptions::where('payment_id', $payment->id)->first();
        if ($existing) {
            return; // دیگه چیزی نساز
        }
        // پلن از طریق relationship لود شده است
        $plan = $payment->plan;
        $startDate = now();

        // محاسبه تاریخ پایان با استفاده از تابع کمکی (فرض شده که وجود دارد)
        $endDate = calculate_end_date($startDate, $plan->duration_days);

        // ثبت رکورد در جدول user_subscriptions
        UserSubscriptions::create([
            'user_id' => $payment->user_id,
            'plan_id' => $plan->id,
            'payment_id' => $payment->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
        ]);
    }

    /**
     * اجرای عملیات در صورت ناموفق بودن پرداخت
     * @param PaymentStatus $status وضعیت جدید پرداخت (مثلا Canceled یا Failed)
     */
    protected function handleFailure(PaymentStatus $status = PaymentStatus::Failed): void
    {
        // به‌روزرسانی وضعیت رکورد Payment
        $this->payment->update([
            // 🔴 از value برای دریافت مقدار از Enum استفاده می کنیم
            'status' => $status->value,
        ]);

        $this->isSuccessful = false;

        // 🔴 اگر شکست از طرف verify بود، پیام در try/catch تنظیم شده، پس اینجا کاری نمی کنیم
        if ($status === PaymentStatus::Failed && $this->message !== 'در حال بررسی وضعیت پرداخت...') {
            return;
        }

        // 🔴 پیام پیش‌فرض برای لغو توسط کاربر
        $this->message = 'عملیات پرداخت لغو شد یا ناموفق بود. برای خرید مجدد تلاش کنید.';
    }

    #[Layout('panel.master')]
    public function render(): View
    {
        // 🔴 نام View را با نام کلاس جدید هماهنگ می‌کنیم
        return view('livewire.panel.payments.payment');
    }
}
