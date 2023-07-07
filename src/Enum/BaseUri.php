<?php

namespace Geocaching\Enum;

Enum BaseUri: string
{
    case STAGING    = 'https://staging.api.groundspeak.com';
    case PRODUCTION = 'https://api.groundspeak.com';
}