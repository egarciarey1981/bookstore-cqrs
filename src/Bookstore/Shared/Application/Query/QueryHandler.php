<?php

namespace Bookstore\Shared\Application\Query;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}
