<?php

namespace Geocaching\Enum;

class ListType extends EnumAbstract
{
    protected static $list = [
                                1 => 'Pocket Query (pq)',
                                2 => 'Bookmark (bm)',
                                3 => 'Ignore (il)',
                                4 => 'Watch (wl)',
                                5 => 'Favorites (fl)',
                            ];
}
