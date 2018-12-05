<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * Abstract Twig page action.
 * Responds with a rendered Twig template with optional data.
 */
abstract class AbstractTwigPage
{

  /**
   * @var \Environment
   */
  protected $twig;

  public function __construct(\Environment $twig)
  {
    $this->twig = $twig;
  }

  /**
   * Returns data passed to the Twig template.
   */
  public function getData(): array
  {
    return [];
  }
  
  /**
   * Returns path to Twig template.
   */
  abstract public function getTemplate(): string;

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
  {
    $data = $this->getData();
    $template = $this->getTemplate();
    $response->getBody()->write($this->twig->render($template, $data));

    return $response;
  }
}
