<?php

namespace Catalog\Application\Command\Book\Delete;

use Catalog\Domain\Model\Book\BookCommandRepository;
use Catalog\Domain\Model\Book\BookNotFoundException;
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

        $this->assertBookExists($command);

        $this->bookRepository->delete(
            new BookId($command->bookId())
        );

        $this->eventBus->publish(
            new BookDeletedEvent(
                new BookId($command->bookId())
            )
        );
    }

    private function assertBookExists(DeleteBookCommand $command): void
    {
        $book = $this->bookRepository->findById(
            new BookId($command->bookId())
        );

        if ($book === null) {
            throw new BookNotFoundException('Book not found', [
                'class' => __CLASS__,
                'payload' => $command->toArray(),
            ]);
        }
    }
}
