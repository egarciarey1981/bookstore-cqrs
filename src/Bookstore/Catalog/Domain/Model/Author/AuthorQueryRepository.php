<?php

namespace Bookstore\Catalog\Domain\Model\Author;

interface AuthorQueryRepository
{
    public function findAll(int $page, int $limit): array;

    public function findById(string $authorId): ?array;

    public function save(array $author): void;

    public function delete(string $authorId): void;
}
