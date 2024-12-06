<?php

namespace Bookstore\Catalog\Domain\Model\Author;

use Bookstore\Shared\Domain\Model\Author\AuthorId;

interface AuthorCommandRepository
{
    public function findAll(): array;

    public function findById(AuthorId $authorId): ?Author;

    public function save(Author $author): void;

    public function delete(Author $author): void;
}
