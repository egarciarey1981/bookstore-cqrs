<?php

namespace Bookstore\Catalog\Domain\Model\Author;

use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Author\AuthorName;

class Author
{
    private AuthorId $authorId;
    private AuthorName $authorName;

    public function __construct(
        AuthorId $authorId,
        AuthorName $authorName,
    ) {
        $this->authorId = $authorId;
        $this->authorName = $authorName;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function authorName(): AuthorName
    {
        return $this->authorName;
    }
}
