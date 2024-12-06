<?php

namespace Shared\Application\Event;

interface EventBus
{
    public function publish(Event $event): void;
}
