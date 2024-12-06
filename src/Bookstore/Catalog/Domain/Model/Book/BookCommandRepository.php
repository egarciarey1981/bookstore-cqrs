<?php

namespace Bookstore\Catalog\Domain\Model\Book;

use Bookstore\Shared\Domain\Model\Book\BookId;

interface BookCommandRepository
{
    public function findAll(): array;

    public function findById(BookId $bookId): ?Book;

    public function save(Book $book): void;

    public function delete(Book $book): void;
}
