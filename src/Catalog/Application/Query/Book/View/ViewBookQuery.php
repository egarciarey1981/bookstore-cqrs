<?php

namespace Catalog\Application\Query\Book\View;

use Shared\Application\Query\Query;

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

    /**
     * @return array<string,string>
     */
    public function toArray(): array
    {
        return [
            'book_id' => $this->bookId,
        ];
    }
}
