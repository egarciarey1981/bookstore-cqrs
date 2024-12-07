<?php

use Catalog\Infrastructure\Http\Slim\Action\Author\CreateAuthorAction;
use Catalog\Infrastructure\Http\Slim\Action\Author\DeleteAuthorAction;
use Catalog\Infrastructure\Http\Slim\Action\Author\ListAuthorsAction;
use Catalog\Infrastructure\Http\Slim\Action\Author\UpdateAuthorAction;
use Catalog\Infrastructure\Http\Slim\Action\Author\ViewAuthorAction;
use Catalog\Infrastructure\Http\Slim\Action\Book\CreateBookAction;
use Catalog\Infrastructure\Http\Slim\Action\Book\DeleteBookAction;
use Catalog\Infrastructure\Http\Slim\Action\Book\ListBooksAction;
use Catalog\Infrastructure\Http\Slim\Action\Book\UpdateBookAction;
use Catalog\Infrastructure\Http\Slim\Action\Book\ViewBookAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/catalog', function (Group $group) {
        $group->group('/authors', function (Group $group) {
            $group->post('', CreateAuthorAction::class);
            $group->get('', ListAuthorsAction::class);
            $group->get('/{author_id}', ViewAuthorAction::class);
            $group->put('/{author_id}', UpdateAuthorAction::class);
            $group->delete('/{author_id}', DeleteAuthorAction::class);
        });
        $group->group('/books', function (Group $group) {
            $group->post('', CreateBookAction::class);
            $group->get('', ListBooksAction::class);
            $group->get('/{book_id}', ViewBookAction::class);
            $group->put('/{book_id}', UpdateBookAction::class);
            $group->delete('/{book_id}', DeleteBookAction::class);
        });
    });
};