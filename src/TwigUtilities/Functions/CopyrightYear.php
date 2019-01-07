<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use Reun\TwigUtilities\AbstractTwigFunction;

class CopyrightYear extends AbstractTwigFunction
{

  public function __invoke($fromYear)
  {
    $startY = \DateTime::createFromFormat("Y", "$fromYear")->format("Y");
    $endY = date("Y");
    return ($startY >= $endY) ? $startY : "$startY-$endY";
  }
}
