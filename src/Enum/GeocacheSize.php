<?php

namespace Geocaching\Enum;

class GeocacheSize extends EnumAbstract
{
    protected static $list = [
                                1 => 'Unknown',
                                2 => 'Micro',
                                3 => 'Regular',
                                4 => 'Large',
                                5 => 'Virtual',
                                6 => 'Other',
                                8 => 'Small',
                            ];
}
