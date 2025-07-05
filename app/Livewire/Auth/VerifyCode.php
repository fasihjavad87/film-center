<?php

namespace App\Livewire\Auth;

use App\Enums\UserStatus;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class VerifyCode extends Component
{
    public $code;

    public function verify()
    {
        $email = session('email_for_verification');
        $name = session('name_for_verification');

        // پیدا کردن OTP معتبر
        $otp = EmailOtp::where('email', $email)
            ->where('code', $this->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            session()->flash('error', 'کد وارد شده نامعتبر یا منقضی شده است');
            return;
        }

        // حذف OTP
        $otp->delete();

        // پیدا کردن کاربر ثبت‌نام‌شده
        $user = User::where('email', $email)->first();

        if (!$user) {
            session()->flash('error', 'کاربری با این ایمیل پیدا نشد.');
            return;
        }

        // به‌روزرسانی ایمیل تأییدشده در صورت نیاز
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
        }

        // به‌روزرسانی وضعیت کاربر با توجه به وضعیت فعلی
        switch ($user->status) {
            case UserStatus::Unverified->value:
            case UserStatus::Verified->value:
                if ($user->email_verified_at) {
                    $user->status = UserStatus::Active->value;
                }
                break;
        }

        $user->save();

        // ورود کاربر
        auth()->login($user, session('remember_me') ?? false);

        // پاک کردن اطلاعات session
        session()->forget([
            'email_for_verification',
            'name_for_verification',
            'remember_me'
        ]);

        return redirect()->route('welcome');
    }

    #[Layout('layouts.auth'), Title('اعتبار سنجی')]
    public function render(): View
    {
        return view('livewire.auth.verify-code');
    }
}
