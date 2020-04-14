<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class StaticTwigPage
{
  private Environment $twig;

  private string $template;

  private array $data;

  public function __construct(Environment $twig, string $template, array $data = [])
  {
    $this->twig = $twig;
    $this->template = $template;
    $this->data = $data;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
  {
    $response->getBody()->write($this->twig->render($this->template, $this->data));

    return $response;
  }
}
