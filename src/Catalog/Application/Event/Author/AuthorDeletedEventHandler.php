<?php

namespace Catalog\Application\Event\Author;

use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Shared\Application\Event\Author\AuthorDeletedEvent;
use Shared\Application\Event\Event;
use Shared\Application\Event\EventHandler;
use Exception;

class AuthorDeletedEventHandler implements EventHandler
{
    private AuthorQueryRepository $authorRepository;

    public function __construct(AuthorQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof AuthorDeletedEvent) {
            throw new Exception('Invalid event');
        }

        $this->authorRepository->delete($event->authorId()->value());
    }
}
