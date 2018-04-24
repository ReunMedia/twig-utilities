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
   * @return string
   */
    public function __invoke($startdate, $enddate)
    {
        $startdate = new DateTime($startdate);
        $enddate = new DateTime($enddate);

        if ($startdate->format("Ymd") === $enddate->format("Ymd")) {
            return $startdate->format("j.n");
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

        $endStr = $enddate->format("j.n");
        return "$startStr-$endStr";
    }
}
