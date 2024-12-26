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

    it(
        "should create additional `<style>` tags for CSS for chunks in production",
        function () {
            $viteAsset = new ViteAsset(
                __DIR__."/../../../fixtures/manifest.json",
                false
            );

            expect($viteAsset("src-www/js/main.ts"))
                ->toContain("main-CXc3meVj.css")
            ;
        }
    );

    describe("dev server asset override", function () {
        it(
            "should allow specifying an optional separate asset that is served
            when using dev server",
            function () {
                // Fake dev server being up
                putenv(ViteAsset::VITE_DEV_SERVER_ENV_KEY."=http://localhost:5173");

                $viteAsset = new ViteAsset(
                    __DIR__."/../../../fixtures/manifest.json",
                    true,
                );

                $result = $viteAsset("src-www/css/style.css", "src-www/css/style2.css");
                expect($result)
                    ->toContain("src-www/css/style2.css")
                    ->and($result)->not->toContain("assets/")
                ;
            }
        );

        it("should not be served if dev server is not running", function () {
            // Fake dev server not being up
            putenv(ViteAsset::VITE_DEV_SERVER_ENV_KEY."=");

            $viteAsset = new ViteAsset(
                __DIR__."/../../../fixtures/manifest.json",
                true,
            );

            $result = $viteAsset("src-www/css/style.css", "src-www/css/style2.css");
            expect($result)
                ->toContain("assets/")
                ->and($result)->not->toContain("src-www")
            ;
        });
    })->after(function () {
        // Clean up dev fake dev server ENV variable
        putenv(ViteAsset::VITE_DEV_SERVER_ENV_KEY);
    });
});
