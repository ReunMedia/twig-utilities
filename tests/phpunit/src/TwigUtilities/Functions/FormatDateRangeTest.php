<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use Codeception\Specify;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @group unit
 * @covers \Reun\TwigUtilities\Functions\FormatDateRange
 */
final class FormatDateRangeTest extends TestCase
{
  use Specify;

  public function testCopyrightYear(): void
  {
    $function = new FormatDateRange();

    $this->it("should output a date range according to finnish date conventions", function () use ($function) {
      $this->assertEquals("1.3.", $function("2017-03-01", "2017-03-01"));
      $this->assertEquals("1.-4.3.", $function("2017-03-01", "2017-03-04"));
      $this->assertEquals("1.3.-4.4.", $function("2017-03-01", "2017-04-04"));
      $this->assertEquals("29.12.2017-4.1.2018", $function("2017-12-29", "2018-01-04"));
      $this->assertEquals("1.1.2017-1.1.2018", $function("2017-01-01", "2018-01-01"));
    });

    $this->it("should always include year with `\$includeYear` argument", function () use ($function) {
      $this->assertEquals("1.3.2017", $function("2017-03-01", "2017-03-01", true));
      $this->assertEquals("1.-4.3.2017", $function("2017-03-01", "2017-03-04", true));
      $this->assertEquals("1.3.-4.4.2017", $function("2017-03-01", "2017-04-04", true));
    });

    $this->specify("use custom delimiter between dates", function () use ($function) {
      $this->assertEquals("1.3. _:_ 4.4.", $function("2017-03-01", "2017-04-04", false, " _:_ "));
    });
  }
}
