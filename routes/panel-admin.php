<?php


use App\Livewire\UserAdmin\Categories\CategoryCreate;
use App\Livewire\UserAdmin\Categories\CategoryEdite;
use App\Livewire\UserAdmin\Countries\CountryCreate;
use App\Livewire\UserAdmin\Countries\CountryEdite;
use App\Livewire\UserAdmin\Countries\CountryList;
use App\Livewire\UserAdmin\DiscountCode\DiscountCodeCreate;
use App\Livewire\UserAdmin\DiscountCode\DiscountCodeEdite;
use App\Livewire\UserAdmin\DiscountCode\DiscountCodeList;
use App\Livewire\UserAdmin\Movies\MovieCreate;
use App\Livewire\UserAdmin\Movies\MovieEdite;
use App\Livewire\UserAdmin\Movies\MovieList;
use App\Livewire\UserAdmin\Panel;
use App\Livewire\UserAdmin\Permissions\PermissionsCreate;
use App\Livewire\UserAdmin\Permissions\PermissionsEdite;
use App\Livewire\UserAdmin\Permissions\PermissionsList;
use App\Livewire\UserAdmin\Plans\PlanCreate;
use App\Livewire\UserAdmin\Plans\PlanEdite;
use App\Livewire\UserAdmin\Plans\PlanList;
use App\Livewire\UserAdmin\Roles\RolesCreate;
use App\Livewire\UserAdmin\Roles\RolesEdite;
use App\Livewire\UserAdmin\Roles\RolesList;
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
Route::get('/', Panel::class)->name('panelAdmin.dashboard')->middleware('permission:show-dashboard');

// Users
Route::get('/users', UserList::class)->name('panelAdmin.users.index')->middleware('permission:show-user');
Route::get('/users/create', UserCreate::class)->name('panelAdmin.users.create')->middleware('permission:create-user');
Route::get('/users/{user}/edite', UserEdite::class)->name('panelAdmin.users.edite')->middleware('permission:edit-user');
Route::get('/users/soft-delete', UserSoftDelete::class)->name('panelAdmin.users.soft.delete')->middleware('permission:delete-user');

//Categories
Route::get('/categories', CategoryList::class)->name('panelAdmin.categories.index')->middleware('permission:show-category');
Route::get('/categories/create', CategoryCreate::class)->name('panelAdmin.categories.create')->middleware('permission:create-category');
Route::get('/categories/{category}/edite', CategoryEdite::class)->name('panelAdmin.categories.edite')->middleware('permission:edit-category');

//Countries
Route::get('/countries', CountryList::class)->name('panelAdmin.countries.index')->middleware('permission:show-country');
Route::get('/countries/create', CountryCreate::class)->name('panelAdmin.countries.create')->middleware('permission:create-country');
Route::get('/countries/{country}/edite', CountryEdite::class)->name('panelAdmin.countries.edite')->middleware('permission:edit-country');

//Movies
Route::get('/movies', MovieList::class)->name('panelAdmin.movies.index')->middleware('permission:show-movie');
Route::get('/movies/create', MovieCreate::class)->name('panelAdmin.movies.create')->middleware('permission:create-movie');
Route::get('/movies/{movie}/edite', MovieEdite::class)->name('panelAdmin.movies.edite')->middleware('permission:edit-movie');

//Series
Route::get('/series', SeriesList::class)->name('panelAdmin.series.index')->middleware('permission:show-series');
Route::get('/series/create', SeriesCreate::class)->name('panelAdmin.series.create')->middleware('permission:create-series');
Route::get('/series/{series}/edite', SeriesEdite::class)->name('panelAdmin.series.edite')->middleware('permission:edit-series');

//Seasons
Route::get('/seasons', SeasonList::class)->name('panelAdmin.seasons.index')->middleware('permission:show-season');
Route::get('/seasons/create', SeasonCreate::class)->name('panelAdmin.seasons.create')->middleware('permission:create-season');
Route::get('/seasons/{season}/edite', SeasonEdite::class)->name('panelAdmin.seasons.edite')->middleware('permission:edit-season');

//Tickets
Route::get('/tickets', TicketsList::class)->name('panelAdmin.tickets.index')->middleware('permission:show-ticket');
Route::get('/tickets/{ticketId}/chat', TicketChat::class)->name('panelAdmin.tickets.show')->middleware('permission:open-ticket');

//Plans
Route::get('/plans', PlanList::class)->name('panelAdmin.plans.index')->middleware('permission:show-plan');
Route::get('/plans/create', PlanCreate::class)->name('panelAdmin.plans.create')->middleware('permission:create-plan');
Route::get('/plans/{plan}/edite', PlanEdite::class)->name('panelAdmin.plans.edite')->middleware('permission:edit-plan');

//DiscountCode
Route::get('/discount-codes', DiscountCodeList::class)->name('panelAdmin.discountCodes.index')->middleware('permission:show-discount-code');
Route::get('/discount-codes/create', DiscountCodeCreate::class)->name('panelAdmin.discountCodes.create')->middleware('permission:create-discount-code');
Route::get('/discount-codes/{discountCode}/edite', DiscountCodeEdite::class)->name('panelAdmin.discountCodes.edite')->middleware('permission:edit-discount-code');

//Roles
Route::get('/roles', RolesList::class)->name('panelAdmin.roles.index')->middleware('permission:show-role');
Route::get('/roles/create', RolesCreate::class)->name('panelAdmin.roles.create')->middleware('permission:create-role');
Route::get('/roles/{role}/edite', RolesEdite::class)->name('panelAdmin.roles.edite')->middleware('permission:edit-role');

//Permissions
Route::get('/permissions', PermissionsList::class)->name('panelAdmin.permissions.index')->middleware('permission:show-permission');
Route::get('/permissions/create', PermissionsCreate::class)->name('panelAdmin.permissions.create')->middleware('permission:create-permission');
Route::get('/permissions/{permission}/edite', PermissionsEdite::class)->name('panelAdmin.permissions.edite')->middleware('permission:edit-permission');


