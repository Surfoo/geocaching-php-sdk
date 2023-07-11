<?php

namespace Geocaching\Enum;

enum TrackableLogType: string
{
    case WRITE_NOTE = 'Write Note';
    case RETRIEVE_IT = 'Retrieve It from a Cache';
    case DROPPED_OFF = 'Dropped Off';
    case TRANSFER = 'Transfer';
    case MARK_MISSING = 'Mark Missing';
    case GRAB_IT = 'Grab It (Not from a Cache)';
    case DISCOVERED_IT = 'Discovered It';
    case MOVE_TO_COLLECTION = 'Move to Collection';
    case MOVE_TO_INVENTORY = 'Move to Inventory';
    case VISITED = 'Visited';

    public function id(): int
    {
        return match($this) {
            self::WRITE_NOTE => 4,
            self::RETRIEVE_IT => 13,
            self::DROPPED_OFF => 14,
            self::TRANSFER => 15,
            self::MARK_MISSING => 16,
            self::GRAB_IT => 19,
            self::DISCOVERED_IT => 48,
            self::MOVE_TO_COLLECTION => 69,
            self::MOVE_TO_INVENTORY => 70,
            self::VISITED => 75,
        };
    }
}