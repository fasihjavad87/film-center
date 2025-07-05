<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyCode;

Route::get('/register', Register::class)->name('auth.register');
Route::get('/login', Login::class)->name('auth.login');
Route::get('/verify-code', VerifyCode::class)->name('auth.verify.code');
Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('auth.login');
})->name('logout');
