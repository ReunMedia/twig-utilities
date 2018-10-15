<?php

namespace Reun\TwigUtilities\Functions;

use \DateTime;
use \Reun\TwigUtilities\TwigFunctionClass;

/**
 * Format two datetime strings.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class FormatDateRange extends TwigFunctionClass
{

  /**
   * Formats two datetime strings according to finnish date conventions.
   * If startdate and enddate are equal only start date is returned.
   *
   * Copied from Vaho project
   *
   * @param string|int|DateTime $startdate
   * @param string|int|DateTime $enddate
   * @param bool $includeYear Always include year in the returned date even if
   * the start and end date are on the same year.
   * @param string $delimiter Delimiter string between dates.
   * @return string
   */
    public function __invoke($startdate, $enddate, bool $includeYear = false, string $delimiter = "-")
    {
        $startdate = ($startdate instanceof DateTime) ? $startdate : new DateTime($startdate);
        $enddate = ($enddate instanceof DateTime) ? $enddate : new DateTime($enddate);

        if ($startdate->format("Ymd") === $enddate->format("Ymd")) {
            $format = $includeYear ? "j.n.Y" : "j.n";
            return $startdate->format($format);
        }

        $startArr = date_parse($startdate->format(DateTime::ATOM));
        $endArr = date_parse($enddate->format(DateTime::ATOM));

        $startStr = "{$startArr['day']}.";

        if ($startArr["month"] !== $endArr["month"] || $startArr["year"] !== $endArr["year"]) {
            $startStr .= "{$startArr['month']}.";
        }
        if ($startArr["year"] !== $endArr["year"]) {
            $startStr .= "{$startArr['year']}";
        }
        
        $format = $includeYear ? "j.n.Y" : "j.n";
        $endStr = $enddate->format($format);
        return "$startStr$delimiter$endStr";
    }
}
