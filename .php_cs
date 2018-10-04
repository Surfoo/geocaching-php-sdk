<?php

/**
 * How to use:
 *
 * $ php-cs-fixer fix --config-file=.php_cs
 *
 * Documentation: https://github.com/FriendsOfPHP/PHP-CS-Fixer
 */

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
;

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@PSR2' => true,
        'binary_operator_spaces' => [
            'align_double_arrow' => true,
            'align_equals' => true,
        ],
        'concat_space' => [
            'spacing' => 'one'
        ],
        'no_empty_statement' => true,
        'include' => true,
        'ordered_imports' => true,
        'phpdoc_indent' => true,
        'phpdoc_align' => true,
        'phpdoc_scalar' => true,
        'phpdoc_trim' => true,
        'no_extra_consecutive_blank_lines' => [
            'use'
        ],
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'cast_spaces' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline_array' => true,
        'no_unused_imports' => true,
    ))
    ->setFinder($finder)
    ->setUsingCache(true)
;