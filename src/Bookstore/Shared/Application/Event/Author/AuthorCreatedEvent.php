<?php

namespace Bookstore\Shared\Application\Event\Author;

use Bookstore\Shared\Application\Event\Event;
use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Author\AuthorName;

class AuthorCreatedEvent implements Event
{
    private AuthorId $authorId;
    private AuthorName $authorName;

    public function __construct(
        AuthorId $authorId,
        AuthorName $authorName
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
