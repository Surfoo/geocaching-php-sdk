<?php

namespace Geocaching\Enum;

enum Environment: string
{
    case STAGING    = 'staging';
    case PRODUCTION = 'production';
}