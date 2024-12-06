<?php

use Catalog\Application\Event\Author\AuthorCreatedEventHandler;
use Catalog\Application\Event\Book\BookCreatedEventHandler;
use Shared\Application\Event\Author\AuthorCreatedEvent;
use Shared\Application\Event\Book\BookCreatedEvent;
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

            // Book
            $eventBus->subscribe(BookCreatedEvent::class, $c->get(BookCreatedEventHandler::class));
            
            return $eventBus;
        },
    ]);
};
