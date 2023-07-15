<?php

namespace Geocaching\Enum;

enum AdditionalWaypointVisibilityType: string
{
    case VISIBLE = 'Visible';
    case HIDE_COORDINATES = 'Hide Coordinates';
    case HIDDEN = 'Hidden';

    public function id(): int
    {
        return match ($this) {
            self::VISIBLE => 0,
            self::HIDE_COORDINATES => 1,
            self::HIDDEN => 2,
        };
    }
}
