<?php

use App\Livewire\Panel\Panel;


//Route::get('/', function () {
//    return 'پنل کاربر لود شد';
//});
Route::get('/', Panel::class)->name('panel.dashboard');
