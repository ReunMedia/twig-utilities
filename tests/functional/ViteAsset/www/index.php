<?php

declare(strict_types=1);

use Reun\TwigUtilities\Functions\ViteAsset;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

require __DIR__."/../vendor/autoload.php";

$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);

$viteAsset = new ViteAsset(__DIR__."/static/dist/.vite/manifest.json", true);
$twig->addFunction(new TwigFunction(
    ViteAsset::getName(),
    [$viteAsset, "__invoke"],
    ViteAsset::getOptions()
));

echo $twig->render("test.twig");
