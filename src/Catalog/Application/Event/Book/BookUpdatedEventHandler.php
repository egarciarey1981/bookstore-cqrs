<?php

namespace Catalog\Application\Event\Book;

use Catalog\Domain\Model\Book\BookQueryRepository;
use Shared\Application\Event\Book\BookUpdatedEvent;
use Shared\Application\Event\Event;
use Shared\Application\Event\EventHandler;
use Exception;

class BookUpdatedEventHandler implements EventHandler
{
    private BookQueryRepository $authorRepository;

    public function __construct(BookQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof BookUpdatedEvent) {
            throw new Exception('Invalid event');
        }

        $this->authorRepository->save([
            'book_id' => $event->bookId()->value(),
            'book_title' => $event->bookTitle()->value(),
            'author_id' => $event->authorId()->value(),
            'author_name' => $event->authorName()->value(),
        ]);
    }
}
