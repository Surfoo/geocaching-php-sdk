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

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR2' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '='   => 'align_single_space_minimal',
                '===' => 'align_single_space_minimal',
                '=>'  => 'align_single_space_minimal',
            ],
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
        'no_extra_blank_lines' => ['tokens' => 
            ['break', 'case', 'continue', 'curly_brace_block',
            'default', 'extra', 'parenthesis_brace_block', 'return',
            'square_brace_block', 'switch', 'throw', 'use', 'use_trait']
        ],
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'cast_spaces' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => true,
        'no_unused_imports' => true,
        'no_superfluous_phpdoc_tags' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
;