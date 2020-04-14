<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

class CopyrightYear extends AbstractFunction
{
  /**
   * @param int|string $fromYear starting year
   * @param int|string $endYear  ending year. Defaults to current year
   */
  public function __invoke($fromYear, $endYear = "now"): string
  {
    $startY = \DateTime::createFromFormat("Y", "{$fromYear}")->format("Y");
    $endY = \DateTime::createFromFormat("Y", "{$endYear}")->format("Y");

    return ($startY >= $endY) ? $startY : "{$startY}-{$endY}";
  }
}
