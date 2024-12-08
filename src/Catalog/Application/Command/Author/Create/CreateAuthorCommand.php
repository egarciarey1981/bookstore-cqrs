<?php

namespace Catalog\Application\Command\Author\Create;

use Shared\Application\Command\Command;

class CreateAuthorCommand implements Command
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
}
