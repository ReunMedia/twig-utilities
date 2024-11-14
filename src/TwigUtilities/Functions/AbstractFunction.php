<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use Reun\TwigUtilities\AbstractTwigFunction;
use Twig\TwigFunction;

/**
 * Base class for Twig functions.
 */
abstract class AbstractFunction extends AbstractTwigFunction
{
    public static function getFunction(): TwigFunction
    {
        return new TwigFunction(static::getName(), [static::class, "__invoke"], static::getOptions());
    }
}
