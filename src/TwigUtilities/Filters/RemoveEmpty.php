<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Filters;

use Reun\TwigUtilities\AbstractTwigFunction;

/**
 * Returns an array without empty elements.
 * 
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class RemoveEmpty extends AbstractTwigFunction
{
  public function __invoke(array $elements)
  {
    return array_filter($elements);
  }
}
