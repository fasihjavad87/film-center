<?php

use App\Livewire\Panel\ActiveDevices\ActiveDeviceList;
use App\Livewire\Panel\Panel;

use App\Livewire\Panel\Payments\Payment;
use App\Livewire\Panel\Plans\PlanList;
use App\Livewire\Panel\PurchaseHistory\PurchaseHistoryList;
use App\Livewire\Panel\Tickets\TicketChat;
use App\Livewire\Panel\Tickets\TicketCreate;
use App\Livewire\Panel\Tickets\TicketsList;
use App\Livewire\Panel\UserProfileEditor\UserProfileEditor;


// Dashboard
Route::get('/', Panel::class)->name('panel.dashboard');

// Tickets
Route::get('/tickets', TicketsList::class)->name('panel.tickets.index');
Route::get('/tickets/create', TicketCreate::class)->name('panel.tickets.create');
Route::get('/tickets/{ticketId}', TicketChat::class)->name('panel.tickets.show');

//Plans
Route::get('/plans', PlanList::class)->name('panel.plans.index');

//Payments
Route::get('/payment_callback', Payment::class)->name('payment.callback');

//PurchaseHistories
Route::get('/my-factors', PurchaseHistoryList::class)->name('panel.purchase-history.index');

//UserProfileEditor
Route::get('/profile-edit', UserProfileEditor::class)->name('panel.user-profile.edit.index');

//ActiveDevices
Route::get('/active-devices', ActiveDeviceList::class)->name('panel.active-devices.index');

