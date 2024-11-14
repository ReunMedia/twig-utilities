<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * Map route to a specific Twig template with optional data.
 */
class StaticTwigPage
{
    public function __construct(
        private Environment $twig,
        private string $template,
        /**
         * @var mixed[]
         */
        private array $data = []
    ) {}

    /**
     * @param array<string,string> $args
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        $response->getBody()->write($this->twig->render($this->template, $this->data));

        return $response;
    }
}
