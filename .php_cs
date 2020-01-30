<?php

declare(strict_types=1);

return PhpCsFixer\Config::create()
  ->setRiskyAllowed(true)
  ->setIndent('  ')
  ->setRules([
    '@PhpCsFixer' => true,
    '@PSR2' => true,
    'declare_strict_types' => true,
    'single_line_comment_style' => false,
    'single_quote' => false,
    'ordered_class_elements' => false,
  ]);
