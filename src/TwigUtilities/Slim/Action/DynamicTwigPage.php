<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Slim\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * Dynamically loads a Twig page based on the request path argument.
 */
class DynamicTwigPage extends AbstractTwigPage
{
    /**
     * Name of the index template page. Used when the path is empty.
     * Path access to the index template is blocked. This means that by default
     * `/index` path always returns 404 by this action.
     */
    public string $indexTemplate = "index";

    /**
     * `page` argument of current request. Used for various dynamic properties.
     * NOTE - `/` is parsed as `$indexTemplate` by the request handler.
     */
    private string $pageArg;

    /**
     * @param string $pagesPrefix Path prefix to Twig pages. Defaults to `@pages`
     *                            Twig namespace which allows you to define the
     *                            path in Twig configuration.
     */
    public function __construct(
        Environment $twig,
        /**
         * Pages directory path.
         */
        private string $pagesPrefix = "@pages"
    ) {
        parent::__construct($twig);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->pageArg = $args["page"] ?? "";

        return parent::__invoke($request, $response, $args);
    }

    /**
     * Get the page name of the current request.
     */
    public function getCurrentPageName(): string
    {
        // By default `pageArg` is determined by the route argument.
        if ($this->pageArg) {
            return $this->pageArg;
        }

        // If page argument is not set either index was requested...
        if (self::class == static::class) {
            return $this->indexTemplate;
        }

        // ... or we're dealing with a subclassed route action in which case the
        // subclass name is used as the page name by default.
        return strtolower(substr(strrchr(static::class, '\\') ?: "", 1));
    }

    public function getTemplate(): string
    {
        $page = $this->getCurrentPageName();

        return "{$this->pagesPrefix}/{$page}/{$page}.twig";
    }

    /**
     * Returns data passed to the Twig template.
     *
     * Returns following dynamic data:
     * - `pageName` - Name of the requested page.
     */
    public function getData(): array
    {
        // Return some default dynamic data based on the current request.
        $page = $this->getCurrentPageName();

        return [
            "pageName" => $page,
        ];
    }
}
