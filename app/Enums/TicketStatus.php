<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case Pending = 'pending';
    case Closed = 'closed';
    case Answered = 'answered';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'باز',
            self::Pending => 'در انتظار پاسخ',
            self::Closed => 'بسته شده',
            self::Answered => 'پاسخ داده‌شده',
        };
    }
}
