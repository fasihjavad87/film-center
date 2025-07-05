<?php

namespace App\Livewire\Auth;

use App\Mail\VerifyEmailCode;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;

    public function sendOtp()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        // ساخت کاربر بدون کد تایید
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'status' => \App\Enums\UserStatus::Unverified->value,
            // بدون email_verified_at چون هنوز تایید نشده
        ]);

        // بعد از ثبت‌نام بفرست به صفحه لاگین با پیغام موفقیت
        return redirect()->route('auth.login')
            ->with('success', 'ثبت‌نام با موفقیت انجام شد. لطفاً وارد شوید.');
    }

    #[Layout('layouts.auth'), Title('ثبت نام')]
    public function render():View
    {
        return view('livewire.auth.register');
    }
}
