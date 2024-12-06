<?php

namespace Shared\Application\Query;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}
