<?php

declare(strict_types=1);

namespace Reun\TwigUtilities;

/**
 * Twig Function defined as an invokable class. Extend this class and add
 * `__invoke()` method as the function implementation.
 */
abstract class AbstractTwigFunction
{
    /**
     * Returns the name of the Twig function.
     *
     * Defaults to camelCased class name (`lcfirst(class)`).
     *
     * @return string Twig function name
     */
    public static function getName(): string
    {
        $classname = static::class;

        return lcfirst(substr($classname, strrpos($classname, "\\") + 1));
    }

    /**
     * Returns the options for this Twig function.
     *
     * @return array<string,mixed> options
     */
    public static function getOptions(): array
    {
        return [];
    }
}
