<?php

namespace Bookstore\Catalog\Application\Query\Author\View;

use Bookstore\Shared\Application\Query\Query;

class ViewAuthorQuery implements Query
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
