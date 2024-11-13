<?php

declare(strict_types=1);

use Reun\TwigUtilities\Filters\Htmlpurify;
use Reun\TwigUtilities\Functions\CopyrightYear;
use Reun\TwigUtilities\Functions\FormatDateRange;
use Twig\Extension\AbstractExtension;

class MyExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            Htmlpurify::getFilter(),
        ];
    }

    public function getFunctions(): array
    {
        return [
            CopyrightYear::getFunction(),
            FormatDateRange::getFunction(),
        ];
    }
}
