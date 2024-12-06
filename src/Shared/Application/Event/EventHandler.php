<?php

namespace Shared\Application\Event;

interface EventHandler
{
    public function handle(Event $event): void;
}
