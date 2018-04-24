<?php

namespace Reun\TwigUtilities;

use \InvalidArgumentException;
use \Twig_Filter;
use \Twig_Function;

/**
 * Trait to convert TwigFunctionClass classes to Twig functions.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
trait FunctionClassToTwigFunctionTrait
{

  /**
   * Converts an TwigFunctionClass to Twig function or filter.
   *
   * @param string $classname Function class name.
   * @param string $type Function type. Either Twig_Function or Twig_Filter.
   * @return Twig_Function|Twig_Filter
   * @throws InvalidArgumentException
   */
    public function functionClassToTwigFunction(string $classname, string $type)
    {
        if ($type !== Twig_Function::class && $type !== Twig_Filter::class) {
            $msg = sprintf(
          "'\$type' must be either '%s' or '%s'",
        Twig_Function::class,
          Twig_Filter::class
      );
            throw new InvalidArgumentException($msg);
        }

        if (!is_subclass_of($classname, TwigFunctionClass::class)) {
            $msg = sprintf(
          "%s is not an instance of %s",
          $classname,
        TwigFunctionClass::class
      );
            throw new InvalidArgumentException($msg);
        }

        if (!method_exists($classname, "__invoke")) {
            $msg = sprintf("%s doesn't implement '__invoke()'", $classname);
            throw new InvalidArgumentException($msg);
        }

        $options = $classname::getOptions();
        $name = $classname::getName();

        $function = new $type($name, [$classname, "__invoke"], $options);
        return $function;
    }

    public function functionClassesToTwigFunctions(array $classes, string $type)
    {
        $f = [];
        foreach ($classes as $classname) {
            $f[] = $this->functionClassToTwigFunction($classname, $type);
        }
        return $f;
    }
}
