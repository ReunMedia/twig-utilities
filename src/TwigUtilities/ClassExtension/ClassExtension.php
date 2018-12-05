<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\ClassExtension;

use Reun\TwigUtilities\AbstractTwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use InvalidArgumentException;

/**
 * Class based Twig extension that supports Function and Filter classes.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class ClassExtension extends AbstractExtension
{

  /** @var Array List of fully qualified class names to use as functions */
  public $functionClasses = [];

  /** @var Array List of fully qualified class names to use as filters */
  public $filterClasses = [];

  public function __construct($functionClasses = [], $filterClasses = [])
  {
    $this->functionClasses = $functionClasses;
    $this->filterClasses = $filterClasses;
  }

  /**
   * Converts an AbstractTwigFunction to a TwigFunction or TwigFilter.
   *
   * @param string $classname Function class name.
   * @param string $type Function type. Either TwigFunction or TwigFilter.
   * @return TwigFilter|TwigFunction
   * @throws InvalidArgumentException
   */
  private function functionClassToTwigFunction(string $classname, string $type)
  {
    $t1 = AbstractTwigFunction::class;
    if (!is_subclass_of($classname, $t1)) {
      $msg = "$classname is not an instance of $t1";
      throw new InvalidArgumentException($msg);
    }

    $t2 = TwigFunction::class;
    $t3 = TwigFilter::class;
    if ($type !== $t2 && $type !== $t3) {
      $msg = "'\$type' must be one of '$t2' or '$t3'";
      throw new InvalidArgumentException($msg);
    }

    $options = $classname::getOptions();
    $name = $classname::getName();

    $function = new $type($name, [$classname, "__invoke"], $options);
    return $function;
  }

  private function functionClassesToTwigFunctions(array $classes, string $type)
  {
    $f = [];
    foreach ($classes as $classname) {
      $f[] = $this->functionClassToTwigFunction($classname, $type);
    }
    return $f;
  }

  public function getFunctions()
  {
    return $this->functionClassesToTwigFunctions($this->functionClasses, TwigFunction::class);
  }

  public function getFilters()
  {
    return $this->functionClassesToTwigFunctions($this->filterClasses, TwigFilter::class);
  }
}
