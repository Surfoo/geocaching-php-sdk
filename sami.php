<?php

/**
 * @see https://github.com/FriendsOfPHP/Sami
 */

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->in('src')
;

return new Sami($iterator, [
    'title'                => 'Geocaching PHP SDK',
    'build_dir'            => __DIR__ . '/docs/',
]);