<?php

declare(strict_types=1);

namespace Reun\TwigUtilities;

/**
 * Twig Function defined as an invokable class. Extend this class and add
 * `__invoke()` method as the function implementation.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
abstract class AbstractTwigFunction
{
    /**
     * Returns the name of the Twig function.
     * Defaults to camelCased class name (`lcfirst(class)`).
     *
     * @return string twig function name
     */
    public static function getName(): string
    {
        $classname = static::class;

        return lcfirst(substr($classname, strrpos($classname, "\\") + 1));
    }

    /**
     * Returns the options for this Twig function.
     *
     * @return array options
     */
    public static function getOptions(): array
    {
        return [];
    }
}
