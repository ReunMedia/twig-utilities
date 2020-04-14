<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use DateTime;

/**
 * Format two datetime strings.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class FormatDateRange extends AbstractFunction
{
  /**
   * Formats two datetime strings according to finnish date conventions.
   * If startdate and enddate are equal only start date is returned.
   *
   * Copied from Vaho project
   *
   * @param DateTime|int|string $startdate
   * @param DateTime|int|string $enddate
   * @param bool                $includeYear always include year in the returned
   *                                         date even if the start and end date
   *                                         are on the same year
   * @param string              $delimiter   delimiter string between dates
   */
  public function __invoke($startdate, $enddate, bool $includeYear = false, string $delimiter = "-"): string
  {
    $startdate = ($startdate instanceof DateTime) ? $startdate : new DateTime($startdate);
    $enddate = ($enddate instanceof DateTime) ? $enddate : new DateTime($enddate);

    // Always include year if start and end date land are on different year.
    if ($startdate->format("Y") != $enddate->format("Y")) {
      $includeYear = true;
    }

    if ($startdate->format("Ymd") === $enddate->format("Ymd")) {
      $format = $includeYear ? "j.n.Y" : "j.n.";

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

    $format = $includeYear ? "j.n.Y" : "j.n.";
    $endStr = $enddate->format($format);

    return "{$startStr}{$delimiter}{$endStr}";
  }
}
