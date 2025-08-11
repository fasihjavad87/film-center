<?php

namespace App\Enums;

enum SeriesStatus: string
{
    case Ongoing = 'ongoing';
    case Ended = 'ended';

    public function label(): string
    {
        return match ($this) {
            self::Ongoing => 'در حال پخش',
            self::Ended => 'پایان یافته',
        };
    }
}
