<?php

use Catalog\Application\Event\Author\AuthorCreatedEventHandler;
use Catalog\Application\Event\Author\AuthorDeletedEventHandler;
use Catalog\Application\Event\Author\AuthorUpdatedEventHandler;
use Catalog\Application\Event\Book\BookCreatedEventHandler;
use Catalog\Application\Event\Book\BookDeletedEventHandler;
use Catalog\Application\Event\Book\BookUpdatedEventHandler;
use Shared\Application\Event\Author\AuthorCreatedEvent;
use Shared\Application\Event\Author\AuthorDeletedEvent;
use Shared\Application\Event\Author\AuthorUpdatedEvent;
use Shared\Application\Event\Book\BookCreatedEvent;
use Shared\Application\Event\Book\BookDeletedEvent;
use Shared\Application\Event\Book\BookUpdatedEvent;
use Shared\Application\Event\EventBus;
use Shared\Infrastructure\Bus\InMemory\InMemoryEventBus;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EventBus::class => function (ContainerInterface $c) {
            $eventBus = new InMemoryEventBus();

            // Author
            $eventBus->subscribe(AuthorCreatedEvent::class, $c->get(AuthorCreatedEventHandler::class));
            $eventBus->subscribe(AuthorDeletedEvent::class, $c->get(AuthorDeletedEventHandler::class));
            $eventBus->subscribe(AuthorUpdatedEvent::class, $c->get(AuthorUpdatedEventHandler::class));

            // Book
            $eventBus->subscribe(BookCreatedEvent::class, $c->get(BookCreatedEventHandler::class));
            $eventBus->subscribe(BookDeletedEvent::class, $c->get(BookDeletedEventHandler::class));
            $eventBus->subscribe(BookUpdatedEvent::class, $c->get(BookUpdatedEventHandler::class));
            
            return $eventBus;
        },
    ]);
};
