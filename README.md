# Twig utilities
This library contains various utilities and components for Twig.

## Functions / Filters
Contain various Twig functions and filters to use with `ClassExtension`.

## ClassExtension
The ClassExtension component provides a way to define Twig filters and functions
as classes. They are registered when the extension is initialized.

### Creating a function (or a filter)
Extend `Reun\TwigUtilities\TwigUtilities\AbstractTwigFunction` and implement the
logic in `__invoke()`. By default the function name is a "camelCased" version of
the class name. Custom name can be specified by overriding `getName()`. Options
can be specified by overriding `getOptions()`
Example:
```php
class Reverse extends AbstractTwigFunction
{
  public function getOptions()
  {
    return ["is_safe" => ["html"]];
  }

  public function __invoke($text)
  {
    return strrev($text);
  }
}
```

### Using the extension
Filters and functions are registered to the extension during instantiation. In
order for extension to find the function classes the
`Twig\ContainerRuntimeLoader` loader must also be added to Twig.

```php
$twig = new \Twig\Environment();

// Register functions and filters and add the extension to Twig.
$functions = [""];
$filters = [Reverse::class];
$myExtension = new ClassExtension($functions, $filters);
$twig->addExtension($myExtension);

// Add ContainerRuntimeLoader to allow the extension to load the classes.
$twig->addRuntimeLoader(new \Twig\RuntimeLoader\ContainerRuntimeLoader());
```

To use other extension features, such as globals, simply extend `ClassExtension`
with your own extension class.


## Slim
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

  public function __construct(NewsManager $newsManager)
  {
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
`TwigLoaderError` middleware can be used to catch it and convert it to Slim's
`NotFoundException` that will be handled by the framework. See [Rendering a 404
page with Twig](#rendering-a-404-page-with-twig) on how to render a 404 page
with Twig.
```php
$app->add(TwigLoaderError::class);
```

### Rendering a 404 page with Twig
You can use Twig to render a custom 404 error page by using
`TwigNotFoundHandler`.
```php
$c["notFoundHandler"] = new TwigNotFoundHandler($twig, "view/404.twig");
```
