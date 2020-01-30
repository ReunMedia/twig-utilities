<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Twig\Error\LoaderError;

/**
 * Catch Twig LoaderErrors and re-throw them as Slim's HttpNotFoundExceptions.
 */
class TwigLoaderError implements MiddlewareInterface
{
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    try {
      return $handler->handle($request);
    } catch (LoaderError $e) {
      throw new HttpNotFoundException($request, null, $e);
    }
  }
}
