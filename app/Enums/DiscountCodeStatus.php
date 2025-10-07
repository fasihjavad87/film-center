<?php

namespace App\Enums;

enum DiscountCodeStatus:string
{
    case Active = 'active';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'فعال',
            self::Inactive => 'غیر فعال',
        };
    }
}
