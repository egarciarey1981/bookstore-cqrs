<?php

use Bookstore\Catalog\Domain\Model\Author\AuthorCommandRepository;
use Bookstore\Catalog\Domain\Model\Author\AuthorQueryRepository;
use Bookstore\Catalog\Domain\Model\Book\BookCommandRepository;
use Bookstore\Catalog\Domain\Model\Book\BookQueryRepository;
use Bookstore\Catalog\Infrastructure\Persistence\InMemory\Command\InMemoryAuthorCommandRepository;
use Bookstore\Catalog\Infrastructure\Persistence\InMemory\Command\InMemoryBookCommandRepository;
use Bookstore\Catalog\Infrastructure\Persistence\InMemory\Query\InMemoryAuthorQueryRepository;
use Bookstore\Catalog\Infrastructure\Persistence\InMemory\Query\InMemoryBookQueryRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        // Author
        AuthorQueryRepository::class => \DI\autowire(InMemoryAuthorQueryRepository::class),
        AuthorCommandRepository::class => \DI\autowire(InMemoryAuthorCommandRepository::class),

        // Book
        BookQueryRepository::class => \DI\autowire(InMemoryBookQueryRepository::class),
        BookCommandRepository::class => \DI\autowire(InMemoryBookCommandRepository::class),
    ]);
};
