<?php

namespace Bookstore\Catalog\Application\Query\Book\View;

use Bookstore\Shared\Application\Query\Query;

class ViewBookQuery implements Query
{
    private string $bookId;

    public function __construct(string $bookId)
    {
        $this->bookId = $bookId;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }
}
