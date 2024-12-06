<?php

namespace Catalog\Domain\Model\Book;

interface BookQueryRepository
{
    /**
     * @return array<string,mixed>[]
     */
    public function findAll(int $page, int $limit, string $sort, string $order): array;

    /**
     * @return array<string,mixed>|null
     */
    public function findById(string $bookId): ?array;

    /**
     * @param array<string,mixed> $book
     */
    public function save(array $book): void;

    public function delete(string $bookId): void;
}
