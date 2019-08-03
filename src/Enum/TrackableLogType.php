<?php

namespace Geocaching\Enum;

class TrackableLogType extends EnumAbstract
{
    protected static $list = [
                                 4 => 'Write Note',
                                13 => 'Retrieve It from a Cache',
                                14 => 'Dropped Off',
                                15 => 'Transfer',
                                16 => 'Mark Missing',
                                19 => 'Grab It (Not from a Cache)',
                                48 => 'Discovered It',
                                69 => 'Move to Collection',
                                70 => 'Move to Inventory',
                                75 => 'Visited',
                            ];
}
