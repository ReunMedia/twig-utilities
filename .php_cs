<?php

return PhpCsFixer\Config::create()
    ->setRules([
        "@PSR2" => true,
        "declare_strict_types" => true,
        "blank_line_after_opening_tag" => true,
        "array_indentation" => true,
    ])
    ->setIndent("  ");
