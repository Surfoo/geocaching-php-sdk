<?php

namespace Geocaching\Enum;

enum GeocacheStatus: string
{
    case UNPUBLISHED = 'Unpublished';
    case ACTIVE      = 'Active';
    case DISABLED    = 'Disabled';
    case LOCKED      = 'Locked';
    case ARCHIVED    = 'Archived';

    public function id(): int
    {
        return match ($this) {
            self::UNPUBLISHED => 1,
            self::ACTIVE      => 2,
            self::DISABLED    => 3,
            self::LOCKED      => 4,
            self::ARCHIVED    => 5,
        };
    }
}
