<?php

namespace Geocaching\Enum;

enum GeocacheLogUpvoteType: string
{
    case UNKNOWN = 'Unknown';
    case MICRO = 'Micro';
    case REGULAR = 'Regular';
    case LARGE = 'Large';
    case VIRTUAL = 'Virtual';
    case OTHER = 'Other';
    case SMALL = 'Small';

    public function id(): int
    {
        return match ($this) {
            self::UNKNOWN => 1,
            self::MICRO => 2,
            self::REGULAR => 3,
            self::LARGE => 4,
            self::VIRTUAL => 5,
            self::OTHER => 6,
            self::SMALL => 8,
        };
    }
}
