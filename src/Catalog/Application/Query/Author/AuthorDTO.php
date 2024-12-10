<?php

namespace Catalog\Application\Query\Author;

class AuthorDTO
{
    private string $authorId;
    private string $authorName;

    public function __construct(
        string $authorId,
        string $authorName,
    ) {
        $this->authorId = $authorId;
        $this->authorName = $authorName;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }

    public function authorName(): string
    {
        return $this->authorName;
    }

    public function toArray(): array
    {
        return [
            'author_id' => $this->authorId,
            'author_name' => $this->authorName,
        ];
    }
}
