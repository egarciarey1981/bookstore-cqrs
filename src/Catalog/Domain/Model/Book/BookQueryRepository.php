<?php

namespace Catalog\Domain\Model\Book;

use Catalog\Application\Query\Book\BookDTO;

interface BookQueryRepository
{
    /**
     * @return BookDTO[]
     */
    public function findAll(int $page, int $limit, string $sort, string $order): array;

    public function findById(string $bookId): ?BookDTO;

    public function save(BookDTO $book): void;

    public function delete(string $bookId): void;
}
