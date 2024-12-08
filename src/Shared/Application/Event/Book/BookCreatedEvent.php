<?php

namespace Shared\Application\Event\Book;

use Shared\Application\Event\Event;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Author\AuthorName;
use Shared\Domain\Model\Book\BookId;
use Shared\Domain\Model\Book\BookTitle;

class BookCreatedEvent implements Event
{
    private BookId $bookId;
    private BookTitle $bookTitle;
    private AuthorId $authorId;
    private AuthorName $authorName;

    public function __construct(
        BookId $bookId,
        BookTitle $bookTitle,
        AuthorId $authorId,
        AuthorName $authorName,
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookTitle(): BookTitle
    {
        return $this->bookTitle;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function authorName(): AuthorName
    {
        return $this->authorName;
    }
}
