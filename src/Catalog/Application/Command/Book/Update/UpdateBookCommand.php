<?php

namespace Catalog\Application\Command\Book\Update;

use Shared\Application\Command\Command;

class UpdateBookCommand implements Command
{
    private string $bookId;
    private string $bookTitle;
    private string $authorId;

    public function __construct(
        string $bookId,
        string $bookTitle,
        string $authorId
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->authorId = $authorId;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }

    public function bookTitle(): string
    {
        return $this->bookTitle;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}
