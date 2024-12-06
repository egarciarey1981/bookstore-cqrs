<?php

declare(strict_types=1);

use Bookstore\Catalog\Domain\Model\Author\AuthorQueryRepository;
use Bookstore\Catalog\Domain\Model\Book\BookQueryRepository;
use Bookstore\Catalog\Infrastructure\Persistence\InMemory\Query\InMemoryAuthorQueryRepository;
use Bookstore\Catalog\Infrastructure\Persistence\InMemory\Query\InMemoryBookQueryRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        AuthorQueryRepository::class => \DI\autowire(InMemoryAuthorQueryRepository::class),
        BookQueryRepository::class => \DI\autowire(InMemoryBookQueryRepository::class),
    ]);
};
