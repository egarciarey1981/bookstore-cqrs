<?php

namespace Shared\Application\Event\Book;

use Shared\Application\Event\Event;
use Shared\Domain\Model\Book\BookId;

class BookDeletedEvent implements Event
{
    private BookId $bookId;

    public function __construct(BookId $bookId)
    {
        $this->bookId = $bookId;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }
}
