<?php

namespace Bookstore\Shared\Application\Event\Book;

use Bookstore\Shared\Application\Event\Event;
use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Author\AuthorName;
use Bookstore\Shared\Domain\Model\Book\BookId;
use Bookstore\Shared\Domain\Model\Book\BookTitle;

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
