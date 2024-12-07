<?php

namespace Catalog\Application\Event\Book;

use Catalog\Domain\Model\Book\BookQueryRepository;
use Shared\Application\Event\Book\BookDeletedEvent;
use Shared\Application\Event\Event;
use Shared\Application\Event\EventHandler;
use Exception;

class BookDeletedEventHandler implements EventHandler
{
    private BookQueryRepository $bookRepository;

    public function __construct(BookQueryRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof BookDeletedEvent) {
            throw new Exception('Invalid event');
        }

        $this->bookRepository->delete($event->bookId()->value());
    }
}
