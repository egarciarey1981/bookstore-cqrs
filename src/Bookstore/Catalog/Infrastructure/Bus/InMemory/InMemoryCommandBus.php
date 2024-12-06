<?php

namespace Bookstore\Catalog\Infrastructure\Bus\InMemory;

use Bookstore\Shared\Application\Command\Command;
use Bookstore\Shared\Application\Command\CommandBus;
use Bookstore\Shared\Application\Command\CommandHandler;
use InvalidArgumentException;

class InMemoryCommandBus implements CommandBus
{
    private array $handlers = [];

    public function registerHandler(string $commandClass, CommandHandler $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function dispatch(Command $command): void
    {
        $commandClass = get_class($command);

        if (!isset($this->handlers[$commandClass])) {
            throw new InvalidArgumentException('Handler not found');
        }

        $handler = $this->handlers[$commandClass];

        $handler->handle($command);
    }
}
