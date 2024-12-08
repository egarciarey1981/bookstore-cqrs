<?php

namespace Catalog\Application\Command\Author\Delete;

use Shared\Application\Command\Command;

class DeleteAuthorCommand implements Command
{
    private string $authorId;

    public function __construct(string $authorId)
    {
        $this->authorId = $authorId;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}
