<?php

/**
 * How to use:
 *
 * $ php-cs-fixer fix --config-file=.php_cs
 *
 * Documentation: https://github.com/FriendsOfPHP/PHP-CS-Fixer
 */

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__ . '/src')
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers(array('phpdoc_params',
                   'phpdoc_scalar',
                   'phpdoc_trim',
                   'phpdoc_indent',
                   'duplicate_semicolon',
                   'ternary_spaces',
                   'include',
                   'concat_with_spaces',
                   'spaces_cast',
                   'short_array_syntax',
                   'ordered_use',
                   'align_double_arrow',
                   'align_equals',
                   'unused_use',
                   'remove_lines_between_uses'
                    ))
    ->finder($finder)
    ->setUsingCache(true)
;
