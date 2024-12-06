<?php

namespace Shared\Infrastructure\Bus\InMemory;

use Shared\Application\Event\Event;
use Shared\Application\Event\EventBus;
use Shared\Application\Event\EventHandler;
use Exception;

final class InMemoryEventBus implements EventBus
{
    /**
     * @var array<string,EventHandler[]>
     */
    private array $listeners;

    public function subscribe(string $eventName, EventHandler $handler): void
    {
        $this->listeners[$eventName][] = $handler;
    }

    public function publish(Event $event): void
    {
        $eventName = get_class($event);

        if (!isset($this->listeners[$eventName])) {
            throw new Exception('No handler for event ' . $eventName);
        }


        foreach ($this->listeners[$eventName] as $handler) {
            $handler->handle($event);
        }
    }
}
