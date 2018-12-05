<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\NotFoundException;
use Twig\Error\LoaderError;

/**
 * Catch Twig LoaderErrors and convert them to Slim NotFoundExceptions.
 * Use this middleware in production along with TwigNotFoundHandler.
 */
class TwigLoaderError
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
  {
    try {
      return $next($request, $response);
    } catch (LoaderError $e) {
      throw new NotFoundException($request, $response);
    }
  }
}
