<?php

namespace Geocaching\Enum;

class GeocacheType extends EnumAbstract
{
    protected static $list = [
                                 2 => 'Traditional',
                                 3 => 'Multi-Cache',
                                 4 => 'Virtual',
                                 5 => 'Letterbox Hybrid',
                                 6 => 'Event',
                                 8 => 'Mystery/Unknown',
                                 9 => 'Project A.P.E.',
                                11 => 'Webcam',
                                12 => 'Locationless (Reverse) Cache',
                                13 => 'Cache In Trash Out Event',
                               137 => 'Earthcache',
                               453 => 'Mega-Event',
                              1304 => 'GPS Adventures Exhibit',
                              1858 => 'Wherigo',
                              3653 => 'Community Celebration Event',
                              3773 => 'Geocaching HQ',
                              3774 => 'Geocaching HQ Celebration',
                              4738 => 'Geocaching HQ Block Party',
                              7005 => 'Giga-Event',
                            ];
}
