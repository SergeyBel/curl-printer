<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__.'/src'])
    ->in([__DIR__.'/tests'])
;

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'semicolon_after_instruction' => true,
    'binary_operator_spaces' => true,
    'function_typehint_space' => true,
    'object_operator_without_whitespace' => true,
    'single_quote' => true,
    'no_trailing_comma_in_list_call' => true,
    'global_namespace_import' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_superfluous_phpdoc_tags' => true,
    'no_empty_phpdoc' => true,
    'no_unused_imports' => true,
    'linebreak_after_opening_tag' => true,
    'array_syntax' => ['syntax' => 'short'],
    'declare_strict_types' => true

])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
