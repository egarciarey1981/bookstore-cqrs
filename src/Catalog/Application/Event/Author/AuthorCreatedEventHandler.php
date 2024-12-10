<?php

namespace Catalog\Application\Event\Author;

use Catalog\Application\Query\Author\AuthorDTO;
use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Shared\Application\Event\Author\AuthorCreatedEvent;
use Shared\Application\Event\Event;
use Shared\Application\Event\EventHandler;
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

        $this->authorRepository->save(new AuthorDTO(
            $event->authorId()->value(),
            $event->authorName()->value(),
        ));
    }
}
