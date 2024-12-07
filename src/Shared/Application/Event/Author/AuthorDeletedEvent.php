<?php

namespace Shared\Application\Event\Author;

use Shared\Application\Event\Event;
use Shared\Domain\Model\Author\AuthorId;

class AuthorDeletedEvent implements Event
{
    private AuthorId $authorId;

    public function __construct(AuthorId $authorId)
    {
        $this->authorId = $authorId;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }
}
