# TwigErrorRenderer

`TwigErrorRenderer` is a [Slim
`ErrorRenderer`](https://www.slimframework.com/docs/v4/middleware/error-handling.html#error-handlingrendering)
that renders errors using Twig templates.

You can specify a separate Twig template for each `Exception` along with a
default catch-all template. It is recommended to only enable `TwigErrorRenderer`
in production.

## Configuration

### Reun PHP App Template

`TwigErrorRenderer` is automatically configured for Reun PHP App Template in the
included definitions. Just include the definitions to enable it in production.

```php
// AppDefinitions.php
$c += TwigUtilitiesDefinitions::getDefinitions();
```

### Manual configuration

```php
// Default error template
$defaultTemplate = "public/errorPages/default.twig";
$templates = [
    // Render Twig loader errors as 404
    LoaderError::class => "public/errorPages/404.twig",
    // Render Slim's NotFoundException as 404
    HttpNotFoundException::class => "public/errorPages/404.twig",
];

$twigErrorRenderer = new TwigErrorRenderer($twig, $defaultTemplate, $templates);

$app
  ->addErrorMiddleware($isDev, true, true)
  ->getDefaultErrorHandler()
  ->registerErrorRenderer("text/html", $twigErrorRenderer);
```

See the [included definitions](../src/TwigUtilities/Config/TwigUtilitiesDefinitions.php) and [Slim documentation](https://www.slimframework.com/docs/v4/middleware/error-handling.html#error-handlingrendering) for additional information.
