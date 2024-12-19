<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Error;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Twig\Error\LoaderError;

/**
 * This middleware wraps Twig's {@see LoaderError} inside Slim's
 * {@see HttpNotFoundException} to let Slim's error handling
 * handle them with correct status code etc.
 *
 * This middleware must be added before Slim's error handling middleware.
 *
 * ```php
 * $app->add(new TwigNotFoundSlimMiddleware());
 * $app->addErrorMiddleware(false, false, false);
 * ```
 */
class TwigNotFoundSlimMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (LoaderError $e) {
            throw new HttpNotFoundException(
                $request,
                null,
                $e
            );
        }
    }
}
