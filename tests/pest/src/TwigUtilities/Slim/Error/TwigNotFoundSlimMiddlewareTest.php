<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reun\TwigUtilities\Slim\Error\TwigNotFoundSlimMiddleware;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Twig\Error\LoaderError;

describe(TwigNotFoundSlimMiddleware::class, function () {
    it("Should respond with 404 status in fully configured Slim app when Twig template is not found", function () {
        $app = AppFactory::create();

        $app->add(new TwigNotFoundSlimMiddleware());
        $app->addErrorMiddleware(false, false, false);

        $app->get("/twig-found", function (
            ServerRequestInterface $request,
            ResponseInterface $response,
            array $args
        ) {
            $response->getBody()->write("Template found!");

            return $response;
        });

        $app->get("/twig-not-found", function (
            ServerRequestInterface $request,
            ResponseInterface $response,
            array $args
        ) {
            // Simulate not finding Twig template by manually throwing a
            // LoaderError
            throw new LoaderError("Template not found");
        });

        $requestFactory = new ServerRequestFactory();

        $responseFound = $app->handle($requestFactory->createServerRequest(
            "GET",
            "/twig-found"
        ));

        expect($responseFound->getStatusCode())->toBe(200);

        $responseNotFound = $app->handle($requestFactory->createServerRequest(
            "GET",
            "/twig-not-found"
        ));

        expect($responseNotFound->getStatusCode())->toBe(404);
    });
});
