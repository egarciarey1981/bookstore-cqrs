<?php

namespace Catalog\Application\Command\Book\Delete;

use Catalog\Application\Command\Book\BookCommandHandler;
use Catalog\Domain\Model\Book\BookNotFoundException;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Book\BookDeletedEvent;
use Shared\Domain\Model\Book\BookId;

class DeleteBookCommandHandler extends BookCommandHandler
{
    public function handle(Command $command): mixed
    {
        if (!$command instanceof DeleteBookCommand) {
            throw new Exception('Invalid command');
        }

        $bookId = new BookId($command->bookId());

        $book = $this->bookRepository->findById($bookId);

        if ($book === null) {
            throw new BookNotFoundException();
        }

        $this->bookRepository->delete($bookId);

        $this->eventBus->publish(new BookDeletedEvent(
            $book->bookId(),
        ));

        return null;
    }
}
