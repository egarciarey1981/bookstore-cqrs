<?php

namespace Catalog\Application\Query\Book\List;

use Shared\Application\Query\Query;

class ListBooksQuery implements Query
{
    private int $page;
    private int $limit;

    public function __construct(
        int $page,
        int $limit,
    ) {
        $this->page = $page;
        $this->limit = $limit;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
