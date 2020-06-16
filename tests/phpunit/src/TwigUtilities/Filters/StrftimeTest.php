<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Filters;

use Codeception\Specify;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @group unit
 * @covers \Reun\TwigUtilities\Filters\Strftime
 */
final class StrftimeTest extends TestCase
{
  use Specify;

  public function testStrftime(): void
  {
    $filter = new Strftime();

    $format = "%Y-%m-%d %H:%M:%s";

    $this->should("Support a string input", function () use ($filter, $format) {
      $date = "tomorrow";
      $this->assertEquals(strftime($format, strtotime($date)), $filter($date, $format));
    });

    $this->should("Support an integer input", function () use ($filter, $format) {
      $date = 1592326390;
      $this->assertEquals(strftime($format, $date), $filter($date, $format));
    });

    $this->should("Support a DateTimeInterface input", function () use ($filter, $format) {
      $date = new DateTime();
      $this->assertEquals(strftime($format, $date->getTimestamp()), $filter($date, $format));

      $date = new DateTimeImmutable();
      $this->assertEquals(strftime($format, $date->getTimestamp()), $filter($date, $format));
    });
  }
}
