<?php


use App\Livewire\UserAdmin\Categories\CategoryCreate;
use App\Livewire\UserAdmin\Categories\CategoryEdite;
use App\Livewire\UserAdmin\Countries\CountryCreate;
use App\Livewire\UserAdmin\Countries\CountryEdite;
use App\Livewire\UserAdmin\Countries\CountryList;
use App\Livewire\UserAdmin\Panel;
use App\Livewire\UserAdmin\Users\UserCreate;
use App\Livewire\UserAdmin\Users\UserEdite;
use App\Livewire\UserAdmin\Users\UserList;
use App\Livewire\UserAdmin\Users\UserSoftDelete;
use App\Livewire\UserAdmin\Categories\CategoryList;

// Dashboard
Route::get('/', Panel::class)->name('panelAdmin.dashboard');

// Users
Route::get('/users', UserList::class)->name('panelAdmin.users.index');
Route::get('/users/create', UserCreate::class)->name('panelAdmin.users.create');
Route::get('/users/{user}/edite', UserEdite::class)->name('panelAdmin.users.edite');
Route::get('/users/soft-delete', UserSoftDelete::class)->name('panelAdmin.users.soft.delete');

//Categories
Route::get('/categories', CategoryList::class)->name('panelAdmin.categories.index');
Route::get('/categories/create', CategoryCreate::class)->name('panelAdmin.categories.create');
Route::get('/categories/{category}/edite', CategoryEdite::class)->name('panelAdmin.categories.edite');

//Countries
Route::get('/countries', CountryList::class)->name('panelAdmin.countries.index');
Route::get('/countries/create', CountryCreate::class)->name('panelAdmin.countries.create');
Route::get('/countries/{country}/edite', CountryEdite::class)->name('panelAdmin.countries.edite');


