<?php

namespace Shared\Application\Event\Book;

use Shared\Application\Event\Event;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Author\AuthorName;
use Shared\Domain\Model\Book\BookId;
use Shared\Domain\Model\Book\BookTitle;

class BookCreatedEvent implements Event
{
    private AuthorId $authorId;
    private AuthorName $authorName;
    private BookId $bookId;
    private BookTitle $bookTitle;

    public function __construct(
        AuthorId $authorId,
        AuthorName $authorName,
        BookId $bookId,
        BookTitle $bookTitle
    ) {
        $this->authorId = $authorId;
        $this->authorName = $authorName;
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function authorName(): AuthorName
    {
        return $this->authorName;
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
