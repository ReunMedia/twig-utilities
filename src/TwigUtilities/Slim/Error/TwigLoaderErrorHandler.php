<?php
/**
 * Slim error handler for Twig LoaderError.
 *
 * This error handler re-throws Twig's LoaderErrors as Slim's
 * HttpNotFoundExceptions.
 */

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Error;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;
use Twig\Error\LoaderError;

class TwigLoaderErrorHandler implements ErrorHandlerInterface
{
  public function __invoke(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails): ResponseInterface
  {
    if (Throwable instanceof LoaderError) {
      throw new HttpNotFoundExceptions($request, null, $exception);
    }

    throw $exception;
  }
}
