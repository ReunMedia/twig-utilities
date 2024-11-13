<?php

declare(strict_types=1);

use DI\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\ContainerRuntimeLoader;

require_once "../../../vendor/autoload.php";

require_once "./MyExtension.php";

$loader = new FilesystemLoader();
$loader->addPath(__DIR__."/view", "view");
$twig = new Environment($loader, ["debug" => true]);
$twig->addRuntimeLoader(new ContainerRuntimeLoader(new Container()));

$twig->addExtension(new MyExtension());

echo $twig->render("@view/test.twig");
