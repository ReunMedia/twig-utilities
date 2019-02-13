<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Extensions\PhpDebugBar;

use DebugBar\JavascriptRenderer;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * Extension for rendering PHP Debug Bar in Twig templates.
 * 
 * Adds a single global array named `phpDebugBar` containing following keys:
 * renderHead, js, css, head, render, enabled
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class PhpDebugBar extends AbstractExtension implements GlobalsInterface
{

  /** @var JavascriptRenderer */
  private $renderer;

  public function __construct(JavascriptRenderer $renderer)
  {
    $this->renderer = $renderer;
  }

  public function getGlobals()
  {
    ob_start();
    $this->renderer->dumpJsAssets();
    $js = ob_get_clean();

    ob_start();
    $this->renderer->dumpCssAssets();
    $css = ob_get_clean();

    ob_start();
    $this->renderer->dumpHeadAssets();
    $head = ob_get_clean();

    return [
      "phpDebugBar" => [
        "renderHead" => $this->renderer->renderHead(),
        "js" => $js,
        "css"=> $css,
        "head"=> $head,
        "render" => $this->renderer->render(),
        "enabled" => true,
      ]
    ];
  }
}
