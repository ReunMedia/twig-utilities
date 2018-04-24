<?php

namespace Reun\TwigUtilities;

/**
 * Twig Function defined as an invokable class. Extend this class and add
 * `__invoke()` method as the function implementation.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
abstract class TwigFunctionClass
{

  /**
   * Returns the name of the Twig function.
   * Defaults to camelCased class name (`lcfirst(class)`).
   * @return string Twig function name
   */
  public static function getName()
  {
    $classname = static::class;
    return lcfirst(substr($classname, strrpos($classname, "\\") + 1));
  }

  /**
   * Returns the options for this Twig function.
   * @return Array Options
   */
  public static function getOptions()
  {
    return [];
  }
}
