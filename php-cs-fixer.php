<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__.'/config')
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PSR12' => true,
            'declare_strict_types' => true,
            'ordered_imports' => [
                'imports_order' => ['class', 'function', 'const'],
                'sort_algorithm' => 'alpha',
            ],
            'no_unused_imports' => true,
            'trailing_comma_in_multiline' => true,
            'binary_operator_spaces' => [
                'operators' => [
                    '=>' => 'align_single_space_minimal',
                    '=' => 'align_single_space_minimal',
                ],
            ],
            'no_extra_blank_lines' => [
                'tokens' => [
                    'attribute',
                    'break',
                    'case',
                    'continue',
                    'curly_brace_block',
                    'default',
                    'extra',
                    'parenthesis_brace_block',
                    'return',
                    'square_brace_block',
                    'switch',
                    'throw',
                    'use',
                ],
            ],
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => true,
                'attribute_placement' => 'standalone',
            ],
            'array_syntax' => ['syntax' => 'short'],
        ]
    )
    ->setFinder($finder);
