<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    // اگر Blade سفارشی داری
    public function getView(): string
    {
        return 'filament.resources.ticket-resource.pages.view-ticket';
    }
}
