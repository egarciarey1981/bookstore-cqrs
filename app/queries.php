<?php

use Bookstore\Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Bookstore\Catalog\Application\Query\Author\List\ListAuthorsQueryHandler;
use Bookstore\Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Bookstore\Catalog\Application\Query\Author\View\ViewAuthorQueryHandler;
use Bookstore\Catalog\Application\Query\Book\List\ListBooksQuery;
use Bookstore\Catalog\Application\Query\Book\List\ListBooksQueryHandler;
use Bookstore\Catalog\Application\Query\Book\View\ViewBookQuery;
use Bookstore\Catalog\Application\Query\Book\View\ViewBookQueryHandler;
use Bookstore\Catalog\Infrastructure\Bus\InMemory\InMemoryQueryBus;
use Bookstore\Shared\Application\Query\QueryBus;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        QueryBus::class => function (ContainerInterface $c) {
            $queryBus = new InMemoryQueryBus();

            // Author
            $queryBus->registerHandler(ListAuthorsQuery::class, $c->get(ListAuthorsQueryHandler::class));
            $queryBus->registerHandler(ViewAuthorQuery::class, $c->get(ViewAuthorQueryHandler::class));

            // Book
            $queryBus->registerHandler(ListBooksQuery::class, $c->get(ListBooksQueryHandler::class));
            $queryBus->registerHandler(ViewBookQuery::class, $c->get(ViewBookQueryHandler::class));

            return $queryBus;
        },
    ]);
};
