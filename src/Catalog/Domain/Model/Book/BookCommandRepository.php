<?php

namespace Catalog\Domain\Model\Book;

use Shared\Domain\Model\Book\BookId;

interface BookCommandRepository
{
    public function nextIdentity(): BookId;

    public function findAll(): array;

    public function findById(BookId $bookId): ?Book;

    public function save(Book $book): void;

    public function delete(Book $book): void;
}
