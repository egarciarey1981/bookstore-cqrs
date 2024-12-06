<?php

use Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Catalog\Application\Query\Author\List\ListAuthorsQueryHandler;
use Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Catalog\Application\Query\Author\View\ViewAuthorQueryHandler;
use Catalog\Application\Query\Book\List\ListBooksQuery;
use Catalog\Application\Query\Book\List\ListBooksQueryHandler;
use Catalog\Application\Query\Book\View\ViewBookQuery;
use Catalog\Application\Query\Book\View\ViewBookQueryHandler;
use Catalog\Infrastructure\Bus\InMemory\InMemoryQueryBus;
use Shared\Application\Query\QueryBus;
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
