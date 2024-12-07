<?php

namespace Shared\Application\Event\Author;

use Shared\Application\Event\Event;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Author\AuthorName;

class AuthorUpdatedEvent implements Event
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
