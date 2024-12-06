<?php

use Bookstore\Catalog\Application\Command\Author\Create\CreateAuthorCommand;
use Bookstore\Catalog\Application\Command\Author\Create\CreateAuthorCommandHandler;
use Bookstore\Catalog\Application\Command\Book\Create\CreateBookCommand;
use Bookstore\Catalog\Application\Command\Book\Create\CreateBookCommandHandler;
use Bookstore\Catalog\Infrastructure\Bus\InMemory\InMemoryCommandBus;
use Bookstore\Shared\Application\Command\CommandBus;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CommandBus::class => function (ContainerInterface $c) {
            $commandBus = new InMemoryCommandBus();

            // Author
            $commandBus->registerHandler(CreateAuthorCommand::class, $c->get(CreateAuthorCommandHandler::class));

            // Book
            $commandBus->registerHandler(CreateBookCommand::class, $c->get(CreateBookCommandHandler::class));

            return $commandBus;
        },
    ]);
};
