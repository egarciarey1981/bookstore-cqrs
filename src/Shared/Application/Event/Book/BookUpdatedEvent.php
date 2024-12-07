<?php

namespace Shared\Application\Event\Book;

use Shared\Application\Event\Event;
use Shared\Domain\Model\Book\BookId;
use Shared\Domain\Model\Book\BookTitle;

class BookUpdatedEvent implements Event
{
    private BookId $bookId;
    private BookTitle $bookTitle;

    public function __construct(
        BookId $bookId,
        BookTitle $bookTitle
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookTitle(): BookTitle
    {
        return $this->bookTitle;
    }
}
