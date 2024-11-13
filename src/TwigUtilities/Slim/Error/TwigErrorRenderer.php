<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Error;

use Slim\Interfaces\ErrorRendererInterface;
use Twig\Environment;

/**
 * Twig template renderer for Slim errors.
 */
class TwigErrorRenderer implements ErrorRendererInterface
{
    /**
     * @param string $defaultTemplate default template used when no template is
     *                                given for a specific exception
     */
    public function __construct(
        private Environment $twig,
        /**
         * Default template used when no template is given for a specific exception.
         */
        private string $defaultTemplate,
        /**
         * Templates to render for different exceptions.
         *
         * Array keys are exception types and values are Twig templates.
         *
         * @var array<class-string<\Throwable>,string>
         */
        private array $templates = []
    ) {}

    public function __invoke(\Throwable $exception, bool $displayErrorDetails): string
    {
        $template = $this->defaultTemplate;
        foreach ($this->templates as $cls => $tpl) {
            if (\is_a($exception, $cls)) {
                $template = $tpl;
            }
        }

        return $this->twig->render($template, [
            "exception" => $exception,
            "displayErrorDetails" => $displayErrorDetails,
        ]);
    }
}
