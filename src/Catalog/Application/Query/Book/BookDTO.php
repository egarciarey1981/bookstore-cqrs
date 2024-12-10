<?php

namespace Catalog\Application\Query\Book;

class BookDTO
{
    private string $bookId;
    private string $bookTitle;
    private string $authorId;
    private string $authorName;

    public function __construct(
        string $bookId,
        string $bookTitle,
        string $authorId,
        string $authorName,
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
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

    public function authorName(): string
    {
        return $this->authorName;
    }

    public function toArray(): array
    {
        return [
            'book_id' => $this->bookId,
            'book_title' => $this->bookTitle,
            'author_id' => $this->authorId,
            'author_name' => $this->authorName,
        ];
    }
}
