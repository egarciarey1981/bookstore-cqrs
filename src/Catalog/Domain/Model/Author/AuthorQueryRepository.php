<?php

namespace Catalog\Domain\Model\Author;

interface AuthorQueryRepository
{
    /**
     * @return array<array<string,mixed>>
     */
    public function findAll(int $page, int $limit, string $sort, string $order): array;

    /**
     * @return array<string,mixed>|null
     */
    public function findById(string $authorId): ?array;

    /**
     * @param array<string,mixed> $author
     */
    public function save(array $author): void;

    public function delete(string $authorId): void;
}
