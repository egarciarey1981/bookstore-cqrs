<?php

namespace Catalog\Application\Event\Book;

use Catalog\Application\Query\Book\BookDTO;
use Catalog\Domain\Model\Book\BookQueryRepository;
use Shared\Application\Event\Book\BookCreatedEvent;
use Shared\Application\Event\Event;
use Shared\Application\Event\EventHandler;
use Exception;

class BookCreatedEventHandler implements EventHandler
{
    private BookQueryRepository $authorRepository;

    public function __construct(BookQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof BookCreatedEvent) {
            throw new Exception('Invalid event');
        }

        $this->authorRepository->save(new BookDTO(
            $event->bookId()->value(),
            $event->bookTitle()->value(),
            $event->authorId()->value(),
            $event->authorName()->value(),
        ));
    }
}
