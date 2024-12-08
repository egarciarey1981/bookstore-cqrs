<?php

namespace Catalog\Application\Command\Author\Update;

use Shared\Application\Command\Command;

class UpdateAuthorCommand implements Command
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

    /**
     * @return array<string,string>
     */
    public function toArray(): array
    {
        return [
            'author_id' => $this->authorId,
            'author_name' => $this->authorName,
        ];
    }
}
