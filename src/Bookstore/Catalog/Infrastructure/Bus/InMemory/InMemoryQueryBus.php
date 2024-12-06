<?php

namespace Bookstore\Catalog\Infrastructure\Bus\InMemory;

use Bookstore\Shared\Application\Query\Query;
use Bookstore\Shared\Application\Query\QueryBus;
use Bookstore\Shared\Application\Query\QueryHandler;
use InvalidArgumentException;

class InMemoryQueryBus implements QueryBus
{
    private array $handlers = [];

    public function registerHandler(string $queryClass, QueryHandler $handler): void
    {
        $this->handlers[$queryClass] = $handler;
    }

    public function ask(Query $query): mixed
    {
        $queryClass = get_class($query);

        if (!isset($this->handlers[$queryClass])) {
            throw new InvalidArgumentException('Handler not found');
        }

        $handler = $this->handlers[$queryClass];

        return $handler->handle($query);
    }
}
