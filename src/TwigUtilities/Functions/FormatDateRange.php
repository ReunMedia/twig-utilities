<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

/**
 * Format two datetime strings according to Finnish date conventions.
 */
class FormatDateRange extends AbstractFunction
{
    /**
     * Formats two datetime strings according to Finnish date conventions.
     * If startdate and enddate are equal only start date is returned.
     *
     * @param \DateTimeInterface|int|string $startdate
     * @param \DateTimeInterface|int|string $enddate
     * @param bool                          $includeYear always include year in the returned
     *                                                   date even if the start and end date
     *                                                   are on the same year
     * @param string                        $delimiter   delimiter string between dates
     */
    public function __invoke(
        $startdate,
        $enddate,
        bool $includeYear = false,
        string $delimiter = "-"
    ): string {
        $startdate = (is_int($startdate)) ? "@{$startdate}" : $startdate;
        $enddate = (is_int($enddate)) ? "@{$enddate}" : $enddate;

        $startdate = ($startdate instanceof \DateTimeInterface)
            ? $startdate
            : new \DateTimeImmutable($startdate);
        $enddate = ($enddate instanceof \DateTimeInterface)
            ? $enddate
            : new \DateTimeImmutable($enddate);

        // Always include year if start and end date land are on different year.
        if ($startdate->format("Y") != $enddate->format("Y")) {
            $includeYear = true;
        }

        if ($startdate->format("Ymd") === $enddate->format("Ymd")) {
            $format = $includeYear ? "j.n.Y" : "j.n.";

            return $startdate->format($format);
        }

        // TODO - PHPStan doesn't support type narrowing inside foreach loop.
        // Using a temporary variable as a workaround.
        //
        // See: https://github.com/phpstan/phpstan/issues/7076
        $startArr2 = date_parse($startdate->format(\DateTimeInterface::ATOM));
        $endArr2 = date_parse($enddate->format(\DateTimeImmutable::ATOM));
        $startArr = [];
        $endArr = [];
        foreach (["day", "month", "year"] as $k) {
            if (is_int($startArr2[$k])) {
                $startArr[$k] = $startArr2[$k];
            }
            if (is_int($endArr2[$k])) {
                $endArr[$k] = $endArr2[$k];
            }
        }

        $startStr = "{$startArr['day']}.";

        if ($startArr["month"] !== $endArr["month"]
            || $startArr["year"] !== $endArr["year"]) {
            $startStr .= "{$startArr['month']}.";
        }
        if ($startArr["year"] !== $endArr["year"]) {
            $startStr .= "{$startArr['year']}";
        }

        $format = $includeYear ? "j.n.Y" : "j.n.";
        $endStr = $enddate->format($format);

        return "{$startStr}{$delimiter}{$endStr}";
    }
}
