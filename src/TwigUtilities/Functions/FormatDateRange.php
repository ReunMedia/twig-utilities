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
   * @param string $startdate
   * @param string $enddate
   * @param string $includeYear Always include year in the returned date.
   * @return string
   */
    public function __invoke($startdate, $enddate, $includeYear = false)
    {
        $startdate = new DateTime($startdate);
        $enddate = new DateTime($enddate);

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
        return "$startStr-$endStr";
    }
}
