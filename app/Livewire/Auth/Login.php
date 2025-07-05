<?php

namespace App\Livewire\Auth;

use App\Mail\VerifyEmailCode;
use App\Models\EmailOtp;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{

    public $email;
    public $rememberMe = false;

    public function sendOtp()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email', // فقط ایمیل‌های ثبت‌شده اجازه دارند
        ]);

        $code = rand(100000, 999999);

        EmailOtp::updateOrCreate(
            ['email' => $this->email],
            ['code' => $code, 'expires_at' => now()->addMinutes(5)]
        );

        Mail::to($this->email)->send(new VerifyEmailCode($code));

        session([
            'email_for_verification' => $this->email,
            'remember_me' => $this->rememberMe
        ]);

        return redirect()->route('auth.verify.code');
    }

    #[Layout('layouts.auth'),Title('ورود')]
    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
