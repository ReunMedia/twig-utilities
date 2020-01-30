<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

class CopyrightYear extends AbstractFunction
{
  /**
   * @param int|string $fromYear starting year
   */
  public function __invoke($fromYear): string
  {
    $startY = \DateTime::createFromFormat("Y", "{$fromYear}")->format("Y");
    $endY = date("Y");

    return ($startY >= $endY) ? $startY : "{$startY}-{$endY}";
  }
}
