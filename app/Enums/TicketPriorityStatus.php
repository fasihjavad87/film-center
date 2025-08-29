<?php

namespace App\Enums;

enum TicketPriorityStatus:string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'زیاد',
            self::Medium => 'متوسط',
            self::High => 'کم',
        };
    }
}
