<?php

namespace Catalog\Domain\Model\Book;

use Catalog\Domain\Model\Author\Author;
use Shared\Domain\Model\Book\BookId;
use Shared\Domain\Model\Book\BookTitle;

class Book
{
    private BookId $bookId;
    private BookTitle $bookTitle;
    private Author $author;

    public function __construct(
        BookId $bookId,
        BookTitle $bookTitle,
        Author $author,
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->author = $author;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookTitle(): bookTitle
    {
        return $this->bookTitle;
    }

    public function author(): Author
    {
        return $this->author;
    }
}
