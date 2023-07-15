<?php

namespace Geocaching\Enum;

enum ListType: string
{
    case POCKET_QUERY = 'Pocket Query (pq)';
    case BOOKMARK     = 'Bookmark (bm)';
    case IGNORE       = 'Ignore (il)';
    case WATCH        = 'Watch (wl)';
    case FAVORITES    = 'Favorites (fl)';

    public function id(): int
    {
        return match ($this) {
            self::POCKET_QUERY => 1,
            self::BOOKMARK     => 2,
            self::IGNORE       => 3,
            self::WATCH        => 4,
            self::FAVORITES    => 5,
        };
    }
}
