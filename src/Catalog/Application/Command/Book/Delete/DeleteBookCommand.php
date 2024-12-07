<?php

namespace Catalog\Application\Command\Book\Delete;

use Shared\Application\Command\Command;

class DeleteBookCommand implements Command
{
    private string $bookId;

    public function __construct(string $bookId)
    {
        $this->bookId = $bookId;
    }

    public function getBookId(): string
    {
        return $this->bookId;
    }
}
