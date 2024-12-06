<?php

namespace Bookstore\Shared\Application\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
