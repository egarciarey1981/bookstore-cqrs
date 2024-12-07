<?php

use Catalog\Application\Command\Author\Create\CreateAuthorCommand;
use Catalog\Application\Command\Author\Create\CreateAuthorCommandHandler;
use Catalog\Application\Command\Author\Delete\DeleteAuthorCommand;
use Catalog\Application\Command\Author\Delete\DeleteAuthorCommandHandler;
use Catalog\Application\Command\Author\Update\UpdateAuthorCommand;
use Catalog\Application\Command\Author\Update\UpdateAuthorCommandHandler;
use Catalog\Application\Command\Book\Create\CreateBookCommand;
use Catalog\Application\Command\Book\Create\CreateBookCommandHandler;
use Catalog\Application\Command\Book\Delete\DeleteBookCommand;
use Catalog\Application\Command\Book\Delete\DeleteBookCommandHandler;
use Catalog\Application\Command\Book\Update\UpdateBookCommand;
use Catalog\Application\Command\Book\Update\UpdateBookCommandHandler;
use Catalog\Infrastructure\Bus\InMemory\InMemoryCommandBus;
use Shared\Application\Command\CommandBus;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CommandBus::class => function (ContainerInterface $c) {
            $commandBus = new InMemoryCommandBus();

            // Author
            $commandBus->registerHandler(CreateAuthorCommand::class, $c->get(CreateAuthorCommandHandler::class));
            $commandBus->registerHandler(DeleteAuthorCommand::class, $c->get(DeleteAuthorCommandHandler::class));
            $commandBus->registerHandler(UpdateAuthorCommand::class, $c->get(UpdateAuthorCommandHandler::class));
            
            // Book
            $commandBus->registerHandler(CreateBookCommand::class, $c->get(CreateBookCommandHandler::class));
            $commandBus->registerHandler(DeleteBookCommand::class, $c->get(DeleteBookCommandHandler::class));
            $commandBus->registerHandler(UpdateBookCommand::class, $c->get(UpdateBookCommandHandler::class));

            return $commandBus;
        },
    ]);
};
