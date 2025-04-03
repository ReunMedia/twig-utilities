<?php

/**
 * Reun Media PHP CS Fixer configuration file.
 *
 * @author Reun Media <company@reun.eu>
 * @copyright 2020-2024 Reun Media
 *
 * @see https://github.com/ReunMedia/php-app-template
 *
 * @version 3.0.3
 */

declare(strict_types=1);

use PhpCsFixer\Config;

$config = new Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        "@PER-CS2.0" => true,
        "@PhpCsFixer" => true,

        "declare_strict_types" => true,

        // Prefer double quotes
        "single_quote" => false,

        // Allows us to use /** @disregard */
        "phpdoc_to_comment" => false,

        // These two rules allow us to use `#region` comments for region
        // folding
        "single_line_comment_spacing" => false,
        "single_line_comment_style" => [
            "comment_types" => [
                'asterisk',
            ],
        ],
    ])
;
