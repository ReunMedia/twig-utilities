# ViteAsset

`ViteAsset` function is used to add CSS and JS assets built by Vite to Twig
templates.

## Configuration

### Reun PHP App Template

`ViteAsset` is automatically configured for Reun PHP App Template in the
included definitions.

First include the definitions:

```php
// AppDefinitions.php
$c += TwigUtilitiesDefinitions::getDefinitions();
```

Then add `ViteAsset` function to your `AppExtension`:

```php
// AppExtension.php
public function getFunctions(): array
{
    return [
        ViteAsset::getFunction(),
    ];
}
```

### Manual configuration

```ts
// vite.config.ts
export default defineConfig({
  build: {
    manifest: true, // Manifest must be enabled
    outDir: "www/static/dist",
    rollupOptions: {
      input: {
        style: "src-www/css/main.css",
        main: "src-www/js/main.ts",
      },
    },
  },
  server: {
    host: true,
    port: 5173, // Fixed port must be used for dev server detection
    strictPort: true, // Ensure Vite doesn't choose another port
    origin: "http://localhost:5173", // Must match Vite dev server URL
  },
});
```

```php
// Twig configuration
$viteAsset = new ViteAsset(__DIR__."/path/to/.vite/manifest.json", $isDev);
$twig->addFunction(new TwigFunction(
    ViteAsset::getName(),
    [$viteAsset, "__invoke"],
    ViteAsset::getOptions()
));
```

## Usage

```twig
<head>
  {{viteAsset("src-www/css/style.css")}}
</head>
<body>
  <div id="app"></div>
  {{viteAsset("src-www/js/main.js")}}
</body>
```

## Vite dev server detection

> [!TIP]
>
> Is your app experiencing a delay when dev server is not running? Read the
> following for a fix.

If Vite dev server is not running, `ViteAsset` automatically serves assets from
the latest static build instead. In some cases the runtime dev server detection
may cause significant delay. If this is the case, you can opt for script-based
dev server detection instead.

Script-based dev server detection works by first detecting if dev server is up
and storing the result in an environment variable that is read by `ViteAsset`.

To use script-based detection, modify (or add) `dev` script in your
`composer.json` to include dev server detection (replace `frontend:5173` with
your dev server host and port):

```json
{
  "scripts": {
      "dev": [
          "Composer\\Config::disableProcessTimeout",
          ". vendor/reun/twig-utilities/bin/detect-vite-dev-server.sh && detect_vite frontend:5173 && php -S 0.0.0.0:8080 -t www"
      ]
  }
```

The script also supports detecting multiple dev server URLs and chooses the
first one that responds:

```
...detect_vite frontend:5173 localhost:5173 && php -S...
```
