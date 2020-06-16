<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use DateTimeImmutable;

class CopyrightYear extends AbstractFunction
{
  /**
   * @param int|string $fromYear starting year
   * @param int|string $endYear  ending year. Defaults to current year
   */
  public function __invoke($fromYear, $endYear = null): string
  {
    $endYear = $endYear ?? date("Y");
    $startY = DateTimeImmutable::createFromFormat("Y", "{$fromYear}")->format("Y");
    $endY = DateTimeImmutable::createFromFormat("Y", "{$endYear}")->format("Y");

    return ($startY >= $endY) ? $startY : "{$startY}-{$endY}";
  }
}
