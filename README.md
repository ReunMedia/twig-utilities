# Twig utilities

Various utility filters, functions and Slim integration for Twig.

## Installation

1. Add private package as VCS repository

```sh
composer config --global repositories.reun/twig-utilities vcs git@github.com:Reun-Media/twig-utilities.git
```

2. Install package using Composer
```sh
composer require reun/twig-utilities
```

## Usage - Filters and functions

Functions and filters are defined in separate classes and provide either
`getFilter()` or `getFunction()` static method that can be used to add them to
Twig. The class name beginning with a lowercase character becomes the name of
the filter/function in Twig. E.g. `CopyrightYear` becomes `copyrightYear()`.

The recommended way is to create a new Twig extension for your project and add
filters and functions in `getFilters()` and `getFunctions()`.

```php
use Reun\TwigUtilities\Filters\Strftime;
use Reun\TwigUtilities\Functions\CopyrightYear;
use Twig\Extension\AbstractExtension;

class MyExtension extends AbstractExtension
{
  public function getFilters(): array
  {
    return [
      Strftime::getFilter(),
    ]
  }

  public function getFunctions(): array
  {
    return [
      CopyrightYear::getFunction(),
    ]
  }
}

// Add extension to Twig.
$twig->addExtension(new MyExtension());
```

Some filters and functions have external dependencies. To use them you must add
a [runtime loader](https://twig.symfony.com/doc/3.x/advanced.html#definition-vs-runtime)
to Twig environment.

```php
use DI\Container;
use Twig\RuntimeLoader\ContainerRuntimeLoader;

$twig->addRuntimeLoader(new ContainerRuntimeLoader(new Container()));
```

### Creating new filters and functions

Just extend either `Reun\TwigUtilities\Filters\AbstractFilter` or
`Reun\TwigUtilities\Functions\AbstractFunction` and implement `__invoke()`.
Options can be specified by overriding `getOptions()` method.

## Usage - Slim utilities

The Slim component provides classes that help integrate Twig views into a Slim
application.

### DynamicTwigPage

`DynamicTwigPage` class allows you to easily combine Slim actions with specific
Twig views with support for automatic template rendering based on the requested
route.

To get started simply create a directory for your Twig templates with each page
located in its own subdirectory and assign it to a Twig namespace. Then just
register `DynamicTwigPage` as the catch-all Slim route action.

```
view/public/pages/
  about/
    about.twig
  index/
    index.twig
  news/
    news.twig
```

```php
// Twig configuration
$loader = new FileSystemLoader();
// @pages namespace is used by default.
$loader->addPath("view/public/pages", "pages");
```

```php
// Slim routes
$app->get("/{page}", DynamicTwigPage::class);
```

`DynamicTwigPage` can be extended to provide custom data to templates.

```php
class NewsAction extends DynamicTwigPage
{
  private $newsManager;

  public function __construct(NewsManager $newsManager, Environment $twig, string $pagesPrefix = "@pages")
  {
    parent::__construct($twig, $pagesPrefix);
    $this->newsManager = $newsManager;
  }

  public function getData(): array
  {
    $data = parent::getData();
    $data["news"] = $newsManager->getNews();
    return $data;
  }
}
```

```php
// Slim routes
$app->get("/news", NewsAction::class);
$app->get("/{page}", DynamicTwigPage::class);
```

#### Handling Not Found errors

In case a template is not found, a Twig `LoaderError` is thrown.
`TwigLoaderErrorHandler` can be used to catch it and convert it to Slim's
`NotFoundException` that will be handled by the framework. See [Rendering Slim
errors with Twig](#rendering-slim-errors-with-twig) on how to render error pages
with Twig.

```php
use Reun\TwigUtilities\Slim\Error\TwigLoaderErrorHandler;
use Twig\Error\LoaderError;

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(LoaderError::class, new TwigLoaderErrorHandler());
```

### Rendering Slim errors with Twig

You can use the `Reun\TwigUtilities\Slim\TwigErrorRenderer` class to with Slim
to render error messages. See [Error Handling Middleware](http://www.slimframework.com/docs/v4/middleware/error-handling.html) in Slim documentation for more info.

```php
// definitions.php
$c[TwigErrorRenderer::class] = function(Environment $twig) {
  // Default template used for errors.
  $defaultTemplate = "@pages/errors/default.twig";

  // Templates for specific error types
  $templates = [
    HttpNotFoundException::class => "@pages/errors/notFound.twig",
    HttpForbiddenException::class => "@pages/errors/forbidden.twig",
  ];

  return new TwigErrorRenderer($twig, $defaultTemplate, $templates);
}

// bootstrap.php
$errorHandler->registerErrorRenderer("text/html", TwigErrorRenderer::class)
```

## FAQ and notes

### Where is the Markdown filter?

Use Twig's [`markdown_to_html`](https://twig.symfony.com/doc/2.x/filters/markdown_to_html.html) filter.

### Handling dates and timezones

It is recommended to handle all dates and times as `UTC` and use that as the PHP
timezone setting. Twig's builtin [`date`](https://twig.symfony.com/doc/3.x/filters/date.html)
filter should be used to output dates in a different timezone and can be
combined with `strftime`, `formatDateRange()` etc. See
[Twig's documentation on how to set the timezone](https://twig.symfony.com/doc/3.x/filters/date.html#timezone).

Example of formatting event times in different timezone:

```twig
<div>
  {{ event.startDate|date|strftime('%a')|capitalize }}
  {{ formatDateRange(event.startDate|date, event.endDate|date) }}
</div>
```

## Development

Run `composer functional-test-server` to start a test server. The code is
located in `tests/functional/TwigUtilities`.
