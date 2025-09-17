<?php


use App\Livewire\UserAdmin\Categories\CategoryCreate;
use App\Livewire\UserAdmin\Categories\CategoryEdite;
use App\Livewire\UserAdmin\Countries\CountryCreate;
use App\Livewire\UserAdmin\Countries\CountryEdite;
use App\Livewire\UserAdmin\Countries\CountryList;
use App\Livewire\UserAdmin\Movies\MovieCreate;
use App\Livewire\UserAdmin\Movies\MovieEdite;
use App\Livewire\UserAdmin\Movies\MovieList;
use App\Livewire\UserAdmin\Panel;
use App\Livewire\UserAdmin\Seasons\SeasonCreate;
use App\Livewire\UserAdmin\Seasons\SeasonEdite;
use App\Livewire\UserAdmin\Seasons\SeasonList;
use App\Livewire\UserAdmin\Series\SeriesCreate;
use App\Livewire\UserAdmin\Series\SeriesEdite;
use App\Livewire\UserAdmin\Series\SeriesList;
use App\Livewire\UserAdmin\Tickets\TicketChat;
use App\Livewire\UserAdmin\Tickets\TicketsList;
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

//Movies
Route::get('/movies', MovieList::class)->name('panelAdmin.movies.index');
Route::get('/movies/create', MovieCreate::class)->name('panelAdmin.movies.create');
Route::get('/movies/{movie}/edite', MovieEdite::class)->name('panelAdmin.movies.edite');

//Series
Route::get('/series', SeriesList::class)->name('panelAdmin.series.index');
Route::get('/series/create', SeriesCreate::class)->name('panelAdmin.series.create');
Route::get('/series/{series}/edite', SeriesEdite::class)->name('panelAdmin.series.edite');

//Seasons
Route::get('/seasons', SeasonList::class)->name('panelAdmin.seasons.index');
Route::get('/seasons/create', SeasonCreate::class)->name('panelAdmin.seasons.create');
Route::get('/seasons/{season}/edite', SeasonEdite::class)->name('panelAdmin.seasons.edite');

//Tickets
Route::get('/tickets', TicketsList::class)->name('panelAdmin.tickets.index');
Route::get('/tickets/{ticketId}/chat', TicketChat::class)->name('panelAdmin.tickets.show');
