<?php

use Http\Discovery\ClassDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;

require dirname(__DIR__) . '/vendor/autoload.php';

ClassDiscovery::prependStrategy(MockClientStrategy::class);