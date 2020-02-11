<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Error;

use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;
use Twig\Environment;

/**
 * Twig template renderer for Slim errors.
 */
class TwigErrorRenderer implements ErrorRendererInterface
{
  private ResponseFactoryInterface $responseFactory;
  private Environment $twig;

  /**
   * Default template used when no template is given for a specific exception.
   */
  private string $defaultTemplate;

  /**
   * Templates to render for different exceptions.
   *
   * @var string[]
   */
  private array $templates = [];

  /**
   * @param string   $defaultTemplate default template used when no template is
   *                                  given for a specific exception
   * @param string[] $templates       list of templates for specific exception
   *                                  types where array keys correspond to
   *                                  exception class types
   */
  public function __construct(Environment $twig, string $defaultTemplate, array $templates = [])
  {
    $this->twig = $twig;
    $this->defaultTemplate = $defaultTemplate;
    $this->templates = $templates;
  }

  public function __invoke(Throwable $exception, bool $displayErrorDetails): string
  {
    $template = $this->defaultTemplate;
    foreach ($this->templates as $cls => $tpl) {
      if (\is_subclass_of($exception, $cls)) {
        $template = $tpl;
      }
    }

    return $this->twig->render($template, [
      "exception" => $exception,
      "displayErrorDetails" => $displayErrorDetails,
    ]);
  }
}
