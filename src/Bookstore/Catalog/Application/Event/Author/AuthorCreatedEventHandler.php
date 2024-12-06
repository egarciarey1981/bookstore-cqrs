<?php

namespace Bookstore\Catalog\Application\Event\Author;

use Bookstore\Catalog\Domain\Model\Author\AuthorQueryRepository;
use Bookstore\Shared\Application\Event\Author\AuthorCreatedEvent;
use Bookstore\Shared\Application\Event\Event;
use Bookstore\Shared\Application\Event\EventHandler;
use Exception;

class AuthorCreatedEventHandler implements EventHandler
{
    private AuthorQueryRepository $authorRepository;

    public function __construct(AuthorQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof AuthorCreatedEvent) {
            throw new Exception('Invalid event');
        }

        $this->authorRepository->save([
            'author_id' => $event->authorId()->value(),
            'author_name' => $event->authorName()->value(),
        ]);
    }
}
