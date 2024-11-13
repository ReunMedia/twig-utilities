<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use Reun\TwigUtilities\AbstractTwigFunction;
use Twig\TwigFunction;

/**
 * Description of AbstractFunction.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
abstract class AbstractFunction extends AbstractTwigFunction
{
    public static function getFunction(): TwigFunction
    {
        return new TwigFunction(static::getName(), [static::class, "__invoke"], static::getOptions());
    }
}
