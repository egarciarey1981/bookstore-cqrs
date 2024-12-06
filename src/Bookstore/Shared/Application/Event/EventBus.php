<?php

namespace Bookstore\Shared\Application\Event;

interface EventBus
{
    public function publish(Event $event): void;
}
