<?php

use Bookstore\Catalog\Application\Event\Author\AuthorCreatedEventHandler;
use Bookstore\Shared\Application\Event\Author\AuthorCreatedEvent;
use Bookstore\Shared\Application\Event\EventBus;
use Bookstore\Shared\Infrastructure\Bus\InMemory\InMemoryEventBus;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EventBus::class => function (ContainerInterface $c) {
            $eventBus = new InMemoryEventBus();

            $eventBus->subscribe(AuthorCreatedEvent::class, $c->get(AuthorCreatedEventHandler::class));
            
            return $eventBus;
        },
    ]);
};
