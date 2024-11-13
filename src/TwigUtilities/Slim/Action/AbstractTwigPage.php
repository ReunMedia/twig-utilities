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
    public function __construct(
        protected Environment $twig
    ) {}

    /**
     * @param array<string,string> $args
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $data = $this->getData();
        $template = $this->getTemplate();
        $response->getBody()->write($this->twig->render($template, $data));

        return $response;
    }

    /**
     * Returns data passed to the Twig template.
     *
     * @return array<string,mixed>
     */
    public function getData(): array
    {
        return [];
    }

    /**
     * Returns path to Twig template.
     */
    abstract public function getTemplate(): string;
}
