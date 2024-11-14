# Twig utilities

Various utility filters, functions and Slim integration for Twig.

## Installation

1. Add private package as VCS repository to your project

```sh
composer config repositories.reun/twig-utilities vcs git@github.com:Reun-Media/twig-utilities.git
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
use Reun\TwigUtilities\Filters\Htmlpurify;
use Reun\TwigUtilities\Functions\CopyrightYear;
use Twig\Extension\AbstractExtension;

class MyExtension extends AbstractExtension
{
  public function getFilters(): array
  {
    return [
      Htmlpurify::getFilter(),
    ];
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
a [runtime
loader](https://twig.symfony.com/doc/3.x/advanced.html#definition-vs-runtime) to
Twig environment.

```php
use DI\Container;
use Twig\RuntimeLoader\ContainerRuntimeLoader;

$twig->addRuntimeLoader(new ContainerRuntimeLoader(new Container()));
```

### Creating new filters and functions

Just extend either `Reun\TwigUtilities\Filters\AbstractFilter` or
`Reun\TwigUtilities\Functions\AbstractFunction` and implement `__invoke()`.
Options can be specified by overriding `getOptions()` method.

## Available features

### Filters

|            |                                                                   |
| ---------- | ----------------------------------------------------------------- |
| htmlpurify | Sanitizes a string with [HTML Purifier](http://htmlpurifier.org/) |

### Functions

|                                |                                                            |
| ------------------------------ | ---------------------------------------------------------- |
| copyrightYear                  | Dynamic year range                                         |
| formatDateRange                | Format date and time according to Finnish date conventions |
| [viteAsset](docs/ViteAsset.md) | Add CSS and JS assets built by Vite to Twig templates      |

### Slim utilities

|                                                |                                                           |
| ---------------------------------------------- | --------------------------------------------------------- |
| [DynamicTwigPage](docs/DynamicTwigPage.md)     | Dynamic Slim routing to Twig templates with optional data |
| StaticTwigPage                                 | Map route to a specific Twig template with optional data  |
| [TwigErrorRenderer](docs/TwigErrorRenderer.md) | Render errors as Twig templates                           |

## FAQ and notes

### Where is the Markdown filter?

Use Twig's own
[`markdown_to_html`](https://twig.symfony.com/doc/3.x/filters/markdown_to_html.html)
filter.

### Handling dates and timezones

It is recommended to handle all dates and times as `UTC` and use that as the PHP
timezone setting. Twig's builtin
[`date`](https://twig.symfony.com/doc/3.x/filters/date.html) filter should be
used to output dates in a different timezone and can be combined with
`formatDateRange()` etc. See [Twig's documentation on how to set the
timezone](https://twig.symfony.com/doc/3.x/filters/date.html#timezone).

Example of formatting event times in different timezone:

```twig
<div>
  {{ formatDateRange(event.startDate|date, event.endDate|date) }}
</div>
```

## Development

Run `composer dev` to start a test server. The code is located in
`tests/functional/TwigUtilities`.
