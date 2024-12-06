<?php

namespace Catalog\Application\Query\Book\List;

use Shared\Application\Query\Query;

class ListBooksQuery implements Query
{
    private int $page;
    private int $limit;
    private string $sort;
    private string $order;

    public function __construct(
        int $page,
        int $limit,
        string $sort,
        string $order
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->sort = $sort;
        $this->order = $order;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function sort(): string
    {
        return $this->sort;
    }

    public function order(): string
    {
        return $this->order;
    }
}
