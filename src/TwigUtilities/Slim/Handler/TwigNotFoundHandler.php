<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reun\TwigUtilities\Slim\Action\AbstractTwigPage;
use Twig\Environment;

/**
 * Slim NotFoundHandler that renders a Twig template.
 */
class TwigNotFoundHandler extends AbstractTwigPage
{

  /**
   * @var string Template to render
   */
  private $template;

  public function __construct(Environment $twig, $template)
  {
    parent::__construct($twig);
    $this->template = $template;
  }

  public function getTemplate()
  {
    return $this->template;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
  {
    $response = parent::invoke($request, $response);
    $response = $response->withStatus(404)->withHeader("Content-Type", "text/html");
    return $response;
  }
}
