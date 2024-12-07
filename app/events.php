<?php

use Catalog\Application\Event\Author\AuthorCreatedEventHandler;
use Catalog\Application\Event\Author\AuthorDeletedEventHandler;
use Catalog\Application\Event\Book\BookCreatedEventHandler;
use Catalog\Application\Event\Book\BookDeletedEventHandler;
use Shared\Application\Event\Author\AuthorCreatedEvent;
use Shared\Application\Event\Book\BookCreatedEvent;
use Shared\Application\Event\EventBus;
use Shared\Infrastructure\Bus\InMemory\InMemoryEventBus;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Shared\Application\Event\Author\AuthorDeletedEvent;
use Shared\Application\Event\Book\BookDeletedEvent;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EventBus::class => function (ContainerInterface $c) {
            $eventBus = new InMemoryEventBus();

            // Author
            $eventBus->subscribe(AuthorCreatedEvent::class, $c->get(AuthorCreatedEventHandler::class));
            $eventBus->subscribe(AuthorDeletedEvent::class, $c->get(AuthorDeletedEventHandler::class));

            // Book
            $eventBus->subscribe(BookCreatedEvent::class, $c->get(BookCreatedEventHandler::class));
            $eventBus->subscribe(BookDeletedEvent::class, $c->get(BookDeletedEventHandler::class));
            
            return $eventBus;
        },
    ]);
};
