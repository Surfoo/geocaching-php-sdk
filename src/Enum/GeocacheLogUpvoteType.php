<?php

namespace Geocaching\Enum;

enum GeocacheLogUpvoteType: string
{
    use EnumTrait;

    case GREAT_STORY = 'GreatStory';
    case HELPFUL     = 'Helpful';

    public function id(): int
    {
        return match ($this) {
            self::GREAT_STORY => 1,
            self::HELPFUL     => 2,
        };
    }
}
