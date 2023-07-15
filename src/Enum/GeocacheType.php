<?php

namespace Geocaching\Enum;

enum GeocacheType: string
{
    case TRADITIONAL = 'Traditional';
    case MULTI_CACHE = 'Multi-Cache';
    case VIRTUAL = 'Virtual';
    case LETTERBOX_HYBRID = 'Letterbox Hybrid';
    case EVENT = 'Event';
    case MYSTERY = 'Mystery/Unknown';
    case PROJECT_APE = 'Project A.P.E.';
    case WEBCAM = 'Webcam';
    case LOCATIONLESS = 'Locationless (Reverse) Cache';
    case CITO = 'Cache In Trash Out Event';
    case EARTHCACHE = 'Earthcache';
    case MEGA_EVENT = 'Mega-Event';
    case GPS_ADVENTURES_EXHIBIT = 'GPS Adventures Exhibit';
    case WHERIGO = 'Wherigo';
    case COMMUNITY_CELEBRATION_EVENT = 'Community Celebration Event';
    case GEOCACHING_HQ = 'Geocaching HQ';
    case GEOCACHING_HQ_CELEBRATION = 'Geocaching HQ Celebration';
    case GEOCACHING_HQ_BLOCK_PARTY = 'Geocaching HQ Block Party';
    case GIGA_EVENT = 'Giga-Event';

    public function id(): int
    {
        return match ($this) {
            self::TRADITIONAL => 2,
            self::MULTI_CACHE => 3,
            self::VIRTUAL => 4,
            self::LETTERBOX_HYBRID => 5,
            self::EVENT => 6,
            self::MYSTERY => 8,
            self::PROJECT_APE => 9,
            self::WEBCAM => 11,
            self::LOCATIONLESS => 12,
            self::CITO => 13,
            self::EARTHCACHE => 137,
            self::MEGA_EVENT => 453,
            self::GPS_ADVENTURES_EXHIBIT => 1304,
            self::WHERIGO => 1858,
            self::COMMUNITY_CELEBRATION_EVENT => 3653,
            self::GEOCACHING_HQ => 3773,
            self::GEOCACHING_HQ_CELEBRATION => 3774,
            self::GEOCACHING_HQ_BLOCK_PARTY => 4738,
            self::GIGA_EVENT => 7005,
        };
    }
}
