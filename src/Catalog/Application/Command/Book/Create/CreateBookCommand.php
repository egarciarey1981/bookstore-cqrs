<?php

namespace Catalog\Application\Command\Book\Create;

use Shared\Application\Command\Command;

class CreateBookCommand implements Command
{
    private string $bookTitle;
    private string $authorId;

    public function __construct(
        string $bookTitle,
        string $authorId
    ) {
        $this->bookTitle = $bookTitle;
        $this->authorId = $authorId;
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
