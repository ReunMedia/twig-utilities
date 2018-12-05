<?php

namespace Reun\TwigUtilities\Filters;

use \DateTime;
use Reun\TwigUtilities\AbstractTwigFunction;

/**
 * Description of Strftime
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class Strftime extends AbstractTwigFunction
{
  public function __invoke($date, $format)
  {
    // FIXME - Workaround for %e on Windows. Taken from http://goo.gl/92vR
    // Check for Windows to find and replace the %e modifier correctly
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
      $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
      // Leading zero padding fix from unix format (%-m) to Windows format
      // (%#m)
      $format = preg_replace("/(?<!%)((?:%%)*)%-/", '\1%#', $format);
    }

    $timestamp = ($date instanceof DateTime) ? $date->getTimestamp() : strtotime($date);

    // FIXME - Another Windows workaround
    $formatted = strftime($format, $timestamp);
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
      $formatted = utf8_encode($formatted);
    }
    return $formatted;
  }
}
