<?php

use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Catalog\Domain\Model\Book\BookCommandRepository;
use Catalog\Domain\Model\Book\BookQueryRepository;
use Catalog\Infrastructure\Persistence\InMemory\Command\InMemoryAuthorCommandRepository;
use Catalog\Infrastructure\Persistence\InMemory\Command\InMemoryBookCommandRepository;
use Catalog\Infrastructure\Persistence\InMemory\Query\InMemoryAuthorQueryRepository;
use Catalog\Infrastructure\Persistence\InMemory\Query\InMemoryBookQueryRepository;
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
