<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @group unit
 * @covers \Reun\TwigUtilities\Functions\CopyrightYear
 */
final class CopyrightYearTest extends TestCase
{
  public function testCopyrightYear(): void
  {
    $function = new CopyrightYear();

    $this->assertEquals("2012", $function("2012", "2000"));
    $this->assertEquals("2012", $function(2012, 2012));
    $this->assertEquals("2012-2013", $function(2012, 2013));
  }
}
