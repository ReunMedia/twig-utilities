<?php

declare(strict_types=1);

namespace Reun\TwigUtilities\Functions;

/**
 * Add CSS and JS assets built by Vite to Twig templates.
 *
 * @see /docs/ViteAsset.md
 */
class ViteAsset extends AbstractFunction
{
    public const VITE_DEV_SERVER_ENV_KEY = "VITE_DEV_SERVER_URL";

    /**
     * Parsed contents of manifest JSON file.
     *
     * @var mixed[]
     */
    private array $manifest = [];

    /**
     * Keeps track of whether Vite client is injected to prevent injecting it
     * multiple times.
     */
    private bool $clientInjected = false;

    public function __construct(
        /**
         * Path to `manifest.json` created by Vite. Used to serve static assets
         * when dev server is not running.
         */
        string $manifestFile,
        /**
         * True if running in dev mode. Enables Vite dev server detection.
         */
        bool $isDev,
        /**
         * Base path to static assets.
         */
        private string $staticBasePath = "/static/dist",
        /**
         * Vite dev server URL. Script-based dev server detection overrides this
         * value.
         */
        private string $viteDevServerUrl = "http://localhost:5173",
    ) {
        // Get Vite dev server URL in dev mode. If the URL is empty, we assume
        // the dev server is not running and fallback to latest static build.
        if ($isDev) {
            $this->viteDevServerUrl = $this->getViteDevServerUrl();
        }

        // Load manifest file if Vite dev server is not running.
        if (!$this->viteDevServerUrl) {
            $this->manifest = (array) json_decode(
                file_get_contents($manifestFile) ?: "[]",
                true
            );
        }
    }

    /**
     * @param string $assetName Asset name to get
     */
    public function __invoke(
        string $assetName,
    ): string {
        $result = "";

        // Inject Vite client in dev mode first time this function is called.
        if ($this->viteDevServerUrl && !$this->clientInjected) {
            $result .= $this->createScriptTag($this->assetUrl(
                "@vite/client",
            ));
            $this->clientInjected = true;
        }

        // Get static asset URL from manifest or a URL relative to dev server.
        $assetUrl = $this->assetUrl($assetName);

        // Detect asset URL extension to handle `.css` files.
        $url = parse_url($assetUrl, PHP_URL_PATH);

        if (!$url) {
            throw new \Exception("Invalid asset URL '{$url}'");
        }

        $ext = pathinfo($url, PATHINFO_EXTENSION);

        // Create style tag for CSS files when not in dev mode. Styles are
        // automatically served by Vite in dev mode.
        if ("css" === $ext && !$this->viteDevServerUrl) {
            $result .= $this->createStyleTag($assetUrl);
        } else {
            $result .= $this->createScriptTag($assetUrl);
        }

        return $result;
    }

    /**
     * @return array<string,mixed>
     */
    public static function getOptions(): array
    {
        return [
            "is_safe" => ["html"],
        ];
    }

    private function createScriptTag(string $url): string
    {
        return <<<EOT
      <script type="module" src="{$url}"></script>
      EOT;
    }

    private function createStyleTag(string $url): string
    {
        return <<<EOT
      <link rel="stylesheet" href="{$url}" />
      EOT;
    }

    private function assetUrl(string $assetName): string
    {
        // Use dev server if it's up
        if ($this->viteDevServerUrl) {
            return "{$this->viteDevServerUrl}/{$assetName}";
        }

        $manifest = $this->manifest[$assetName] ?? [];

        if (!is_array($manifest) || !isset($manifest["file"])) {
            trigger_error("Asset '{$assetName}' doesn't exist in manifest");

            return "";
        }

        $file = $manifest["file"];

        return "{$this->staticBasePath}/{$file}";
    }

    private function getViteDevServerUrl(): string
    {
        // We're using `getenv()` instead of `$_ENV` here because the variable
        // is not loaded by Dotenv and PHP doesn't register env variables by
        // default (`variables_order` in `php.ini`)
        $viteUrl = getenv(self::VITE_DEV_SERVER_ENV_KEY);

        // Use runtime dev server detection if no env variable is set.
        if (false === $viteUrl) {
            //
            // This is where the slowdown might happen. The request starts with a
            // DNS query that has a long OS-level timeout. This means that if the
            // dev server URL is not accessible (meaning DNS error, not server
            // error), there's a significant delay before the request fails.
            //
            // There's no easy way to circumvent this in PHP. Trust me. I've spent
            // hours researching and adjusting various cURL options to no avail.
            if (@get_headers($this->viteDevServerUrl)) {
                return $this->viteDevServerUrl;
            }
        }

        if (!$viteUrl) {
            return "";
        }

        // `http://` is not always used when detecting the URL, so we add it
        // if it doesn't exist and the dev server is up.
        return null === parse_url($viteUrl, PHP_URL_SCHEME)
            ? "http://{$viteUrl}"
            : $viteUrl;
    }
}
