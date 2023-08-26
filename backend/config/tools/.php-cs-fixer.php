<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/../../src')
    ->in(__DIR__ . '/../../tests/unit')
    ->exclude('config')
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
    ]);
