# Twig utilities

This library makes it easier to use individual classes as Twig filters and
functions.

## Usage
1. Extend or create a new instance of `\Reun\TwigUtilities\TwigExtension`

```php
class MyExtension extends \Reun\TwigUtilities\TwigExtension
```


2. Define a class based function or a filter

```php
class LinkWrap extends \Reun\TwigUtilities\TwigFunctionClass
{
  // Override `getOptions()` to define options.
  public static function getOptions()
  {
    return ["is_safe" => "html"];
  }

  // Function is called via __invoke.
  public static function __invoke($text, $href)
  {
    return "<a href='$href'>$text</a>";
  }
}
```
The function/filter name will be the lowercase first name of the class name.
In this example it would be `linkWrap`. You can override `getName()` to define
a custom name.


3. Register filters and functions when instantiating the extension

Filters and functions are registered by passing their fully qualified names to
the Twig extension constructor.
```php
$functions = [LinkWrap::class];
$filters = [/*Add filter classes here*/];
$myExtension = new MyExtension($functions, $filters);
$twig->addExtension($myExtension);
```


4. Add runtime loader to Twig

In order for Twig to instantiate classes with constructor arguments a runtime
loader should be provided. Twig comes with a built-in PSR-11 loader that can be
used.
```php
$twig->addRuntimeLoader(new \Twig\RuntimeLoader\ContainerRuntimeLoader($c));
```
