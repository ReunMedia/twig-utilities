<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

class CopyrightYear extends AbstractFunction
{
    /**
     * @param int|string $fromYear starting year
     * @param int|string $endYear  ending year. Defaults to current year
     */
    public function __invoke($fromYear, $endYear = null): string
    {
        $endYear = $endYear ?? date("Y");
        $startYDt = \DateTimeImmutable::createFromFormat("Y", "{$fromYear}");
        $endYDt = \DateTimeImmutable::createFromFormat("Y", "{$endYear}");
        $startY = (bool) $startYDt ? $startYDt->format("Y") : "";
        $endY = (bool) $endYDt ? $endYDt->format("Y") : "";

        return ($startY >= $endY) ? $startY : "{$startY}-{$endY}";
    }
}
