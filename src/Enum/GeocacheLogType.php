<?php

namespace Geocaching\Enum;

class GeocacheLogType extends EnumAbstract
{
    protected static $list = [
                                 2 => 'Found It',
                                 3 => 'Didn\'t find it',
                                 4 => 'Write note',
                                 5 => 'Archive',
                                 6 => 'Permanently Archived',
                                 7 => 'Needs Archived',
                                 9 => 'Will Attend',
                                10 => 'Attended',
                                11 => 'Webcam Photo Taken',
                                12 => 'Unarchive',
                                22 => 'Temporarily Disable Listing',
                                23 => 'Enable Listing',
                                24 => 'Publish Listing ',
                                25 => 'Retract Listing',
                                45 => 'Needs Maintenance',
                                46 => 'Owner Maintenance',
                                47 => 'Update Coordinates',
                                68 => 'Post Reviewer Note',
                                74 => 'Announcement',
                                76 => 'Submit for Review',
                            ];
}
