<?php

namespace Geocaching\Enum;

enum MembershipType: string
{
    case UNKNOWN = 'Unknown';
    case BASIC   = 'Basic';
    case CHARTER = 'Charter';
    case PREMIUM = 'Premium';

    public function id(): int
    {
        return match ($this) {
            self::UNKNOWN => 0,
            self::BASIC   => 1,
            self::CHARTER => 2,
            self::PREMIUM => 3,
        };
    }
}
