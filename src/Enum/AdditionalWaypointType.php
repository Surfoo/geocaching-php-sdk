<?php

namespace Geocaching\Enum;

enum AdditionalWaypointType: string
{
    case PARKING_AREA = 'Parking Area';
    case VIRTUAL_STAGE = 'Virtual Stage';
    case PHYSICAL_STAGE = 'Physical Stage';
    case FINAL_LOCATION = 'Final Location';
    case TRAILHEAD = 'Trailhead';
    case REFERENCE_POINT = 'Reference Point';

    public function id(): int
    {
        return match($this) {
            self::PARKING_AREA => 217,
            self::VIRTUAL_STAGE => 218,
            self::PHYSICAL_STAGE => 219,
            self::FINAL_LOCATION => 220,
            self::TRAILHEAD => 221,
            self::REFERENCE_POINT => 452,
        };
    }
}