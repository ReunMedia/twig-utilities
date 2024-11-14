# DynamicTwigPage

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
