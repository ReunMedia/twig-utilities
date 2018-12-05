<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Filters;

use Reun\TwigUtilities\AbstractTwigFunction;

/**
 * HTML Purifier filter.
 * 
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class Htmlpurify extends AbstractTwigFunction
{

  /** @var \HTMLPurifier */
  private $purifier;

  public function __construct(\HTMLPurifier $purifier)
  {
    $this->purifier = $purifier;
  }

  public static function getOptions()
  {
    return ["is_safe" => ["html"]];
  }

  public function __invoke($raw)
  {
    return $this->purifier->purify($raw);
  }
}
