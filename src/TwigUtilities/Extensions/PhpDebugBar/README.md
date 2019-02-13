# PHP Debug Bar extension

To use this extension add following to your definitions
```php
$c[DebugBar::class] = function(ContainerInterface $c) {
  $debugBar = new StandardDebugBar();
  $debugBar->addCollector(...); // Add collectors as needed
  return $debugBar;
}
$c[JavascriptRenderer::class] = DI\factory([DebugBar::class, "getJavascriptRenderer"]);

...

$twig->addExtension($c->get(PhpDebugBar::class));
```

Then render the assets
```twig
// head.twig
{% if phpDebugBar.enabled %}
  <style>{{phpDebugBar.css|raw}}</style>
  <style>{{phpDebugBar.head|raw}}</style>
{% endif %}

// scripts.twig
{% if phpDebugBar.enabled %}
  <script>{{phpDebugBar.js|raw}}</script>
  {{phpDebugBar.render|raw}}
{% endif %}
```
