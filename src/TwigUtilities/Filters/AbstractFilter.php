<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Filters;

use Reun\TwigUtilities\AbstractTwigFunction;
use Twig\TwigFilter;

/**
 * Description of Strftime.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
abstract class AbstractFilter extends AbstractTwigFunction
{
  public static function getFilter(): TwigFilter
  {
    return new TwigFilter(static::getName(), [static::class, "__invoke"], static::getOptions());
  }
}
