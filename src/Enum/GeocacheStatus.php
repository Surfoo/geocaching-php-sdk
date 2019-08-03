<?php

namespace Geocaching\Enum;

class GeocacheStatus extends EnumAbstract
{
    protected static $list = [
                                1 => 'Unpublished',
                                2 => 'Active',
                                3 => 'Disabled',
                                4 => 'Locked',
                                5 => 'Archived',
                            ];
}
