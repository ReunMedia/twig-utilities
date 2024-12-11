<?php

declare(strict_types=1);

use Reun\TwigUtilities\Functions\ViteAsset;

describe(ViteAsset::class, function () {
    it(
        "should not inject client when not in dev mode",
        function () {
            $viteAsset = new ViteAsset(
                __DIR__."/../../../fixtures/manifest.json",
                false
            );

            expect($viteAsset("src-www/js/main.ts"))
                ->not->toContain("@vite/client")
            ;
        }
    );

    it(
        "should always use manifest instead of dev server when not in dev mode",
        function () {
            $viteAsset = new ViteAsset(
                __DIR__."/../../../fixtures/manifest.json",
                false
            );

            expect($viteAsset("src-www/js/main.ts"))
                ->not->toContain("localhost:5173")
            ;
        }
    );
});
