<?php

namespace Catalog\Application\Command\Book\Delete;

use Catalog\Domain\Model\Book\BookCommandRepository;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\Book\BookDeletedEvent;
use Shared\Application\Event\EventBus;
use Shared\Domain\Model\Book\BookId;

class DeleteBookCommandHandler implements CommandHandler
{
    private BookCommandRepository $bookRepository;
    private EventBus $eventBus;

    public function __construct(
        BookCommandRepository $bookRepository,
        EventBus $eventBus,
    ) {
        $this->bookRepository = $bookRepository;
        $this->eventBus = $eventBus;
    }

    public function handle(Command $command): void
    {
        if (!$command instanceof DeleteBookCommand) {
            throw new Exception('Invalid command');
        }

        $bookId = new BookId($command->getBookId());

        $this->bookRepository->delete($bookId);

        $this->eventBus->publish(
            new BookDeletedEvent($bookId)
        );
    }
}
