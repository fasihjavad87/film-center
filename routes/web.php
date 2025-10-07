<?php

use App\Livewire\Front\HomePage;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//})->name('welcome');


Route::get('/', HomePage::class)->name('welcome');
