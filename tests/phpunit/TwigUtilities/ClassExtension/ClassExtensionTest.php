<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Reun\TwigUtilities\ClassExtension\ClassExtension;
use Reun\TwigUtilities\Filters\RemoveEmpty;
use Twig\TwigFunction;

final class ClassExtensionText extends TestCase
{
  public function testGetFunctions(): void
  {
    $ext = new ClassExtension([], []);
    $ext->functionClasses = [self::class];
    $this->expectException(InvalidArgumentException::class);
    $ext->getFunctions();

    $ext->functionClasses = [RemoveEmpty::class];
    assertInstanceOf(TwigFunction::class, $ext->getFunctions()[0]);
  }
}
