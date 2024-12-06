<?php

namespace Catalog\Domain\Model\Author;

use Shared\Domain\Model\Author\AuthorId;

interface AuthorCommandRepository
{
    public function nextIdentity(): AuthorId;

    /**
     * @return Author[]
     */
    public function findAll(): array;

    public function findById(AuthorId $authorId): ?Author;

    public function save(Author $author): void;

    public function delete(Author $author): void;
}
