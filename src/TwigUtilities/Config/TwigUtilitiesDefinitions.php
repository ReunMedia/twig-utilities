<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Config;

use Reun\PhpAppConfig\Config\AbstractAppConfig;
use Reun\PhpAppConfig\Config\DefinitionsInterface;
use Reun\TwigUtilities\Functions\ViteAsset;
use Reun\TwigUtilities\Slim\Error\TwigErrorRenderer;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\ErrorRendererInterface;
use Twig\Environment;
use Twig\Error\LoaderError;

/**
 * Definitions for Reun Twig utilities.
 *
 * Configures `TwigErrorRenderer` as default renderer for errors in production.
 *
 * @see https://github.com/twigphp/Twig
 *
 * @version 1.0.0
 */
final class TwigUtilitiesDefinitions implements DefinitionsInterface
{
    public static function getDefinitions(): array
    {
        $c = [];

        $c[TwigErrorRenderer::class] = function (Environment $twig): TwigErrorRenderer {
            $defaultTemplate = "public/errorPages/default.twig";
            $templates = [
                LoaderError::class => "public/errorPages/404.twig",
                HttpNotFoundException::class => "public/errorPages/404.twig",
            ];

            return new TwigErrorRenderer($twig, $defaultTemplate, $templates);
        };

        // Use Twig error renderer as Slim error renderer
        $c[ErrorRendererInterface::class] = fn (TwigErrorRenderer $x): ErrorRendererInterface => $x;

        $c[ViteAsset::class] = function (AbstractAppConfig $appConfig): ViteAsset {
            return new ViteAsset(
                "{$appConfig->webroot}/static/dist/.vite/manifest.json",
                $appConfig->isDev()
            );
        };

        return $c;
    }
}
