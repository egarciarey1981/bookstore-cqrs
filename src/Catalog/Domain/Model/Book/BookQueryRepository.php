<?php

namespace Catalog\Domain\Model\Book;

interface BookQueryRepository
{
    public function findAll(int $page, int $limit, string $sort, string $order): array;

    public function findById(string $bookId): ?array;

    public function save(array $book): void;

    public function delete(string $bookId): void;
}
