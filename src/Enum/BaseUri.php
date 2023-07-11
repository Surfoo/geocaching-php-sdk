<?php

namespace Geocaching\Enum;

enum BaseUri: string
{
    case STAGING    = 'https://staging.api.groundspeak.com';
    case PRODUCTION = 'https://api.groundspeak.com';
}