<?php

declare(strict_types=1);

use Reun\TwigUtilities\Filters\RemoveEmpty;
use Reun\TwigUtilities\Filters\Strftime;
use Reun\TwigUtilities\Functions\CopyrightYear;
use Reun\TwigUtilities\Functions\FormatDateRange;
use Twig\Extension\AbstractExtension;

class MyExtension extends AbstractExtension
{
  public function getFilters()
  {
    return [
      Strftime::getFilter(),
    ];
  }

  public function getFunctions()
  {
    return [
      CopyrightYear::getFunction(),
      FormatDateRange::getFunction(),
    ];
  }
}
