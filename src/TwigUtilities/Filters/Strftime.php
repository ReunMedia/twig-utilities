<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Filters;

use DateTimeInterface;

/**
 * Strftime filter with Windows locale fix.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class Strftime extends AbstractFilter
{
  /**
   * @param DateTimeInterface|int|string $date   date to format
   * @param string                       $format format string
   */
  public function __invoke($date, string $format): string
  {
    // FIXME - Workaround for %e on Windows. Taken from http://goo.gl/92vR
    // Check for Windows to find and replace the %e modifier correctly
    if ('WIN' == strtoupper(substr(PHP_OS, 0, 3))) {
      $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
      // Leading zero padding fix from unix format (%-m) to Windows format
      // (%#m)
      $format = preg_replace("/(?<!%)((?:%%)*)%-/", '\1%#', $format);
    }

    if (!is_int($date)) {
      $timestamp = ($date instanceof DateTimeInterface) ? $date->getTimestamp() : strtotime($date);
    } else {
      $timestamp = $date;
    }

    // FIXME - Another Windows workaround
    $formatted = strftime($format, $timestamp);
    if ('WIN' == strtoupper(substr(PHP_OS, 0, 3))) {
      $formatted = utf8_encode($formatted);
    }

    return $formatted;
  }
}
