<?php

namespace Bookstore\Catalog\Application\Command\Author\Create;

use Bookstore\Shared\Application\Command\Command;

class CreateAuthorCommand implements Command
{
    private string $authorName;

    public function __construct(string $authorName)
    {
        $this->authorName = $authorName;
    }

    public function authorName(): string
    {
        return $this->authorName;
    }
}