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
