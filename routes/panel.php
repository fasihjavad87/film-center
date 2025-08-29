<?php

use App\Livewire\Panel\Panel;

use App\Livewire\Panel\Tickets\TicketChat;
use App\Livewire\Panel\Tickets\TicketCreate;
use App\Livewire\Panel\Tickets\TicketsList;


//Route::get('/', function () {
//    return 'پنل کاربر لود شد';
//});
Route::get('/', Panel::class)->name('panel.dashboard');


//Route::get('/tickets', TicketsList::class)->name('panel.tickets.index');
//Route::get('/tickets/{ticket}', TicketChat::class)
//    ->name('panel.tickets.show');

Route::name('panel.')->middleware('auth')->group(function () {
    Route::get('/tickets', TicketsList::class)->name('tickets.index');
    Route::get('/tickets/create', TicketCreate::class)->name('tickets.create');
    Route::get('/tickets/{ticket}', TicketChat::class)->name('tickets.show');
});
//Route::get('/tickets/{ticket}', function ($ticket) {
//    return view('livewire.panel.tickets.ticket-chat', ['ticketId' => $ticket]);
//})->name('panel.tickets.show');

