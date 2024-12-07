<?php

namespace Catalog\Application\Event\Author;

use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Shared\Application\Event\Author\AuthorUpdatedEvent;
use Shared\Application\Event\Event;
use Shared\Application\Event\EventHandler;
use Exception;

class AuthorUpdatedEventHandler implements EventHandler
{
    private AuthorQueryRepository $authorRepository;

    public function __construct(AuthorQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof AuthorUpdatedEvent) {
            throw new Exception('Invalid event');
        }

        $this->authorRepository->save([
            'author_id' => $event->authorId()->value(),
            'author_name' => $event->authorName()->value(),
        ]);
    }
}
