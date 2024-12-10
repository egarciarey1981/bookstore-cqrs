<?php

namespace Catalog\Domain\Model\Author;

use Catalog\Application\Query\Author\AuthorDTO;

interface AuthorQueryRepository
{
    /**
     * @return AuthorDTO[]
     */
    public function findAll(int $page, int $limit, string $sort, string $order): array;

    public function findById(string $authorId): ?AuthorDTO;

    public function save(AuthorDTO $author): void;

    public function delete(string $authorId): void;
}
