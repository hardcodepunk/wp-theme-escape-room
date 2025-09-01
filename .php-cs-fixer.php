<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude(['vendor', 'node_modules']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,                 // good baseline
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'single_quote' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'if', 'for', 'foreach', 'while', 'switch']
        ],
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    ])
    ->setFinder($finder);
