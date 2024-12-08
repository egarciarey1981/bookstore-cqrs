<?php

namespace Catalog\Application\Command\Book\Create;

use Catalog\Application\Command\Book\BookCommandHandler;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Catalog\Domain\Model\Book\Book;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Book\BookCreatedEvent;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Book\BookTitle;

class CreateBookCommandHandler extends BookCommandHandler
{
    public function handle(Command $command): string
    {
        if (!$command instanceof CreateBookCommand) {
            throw new Exception('Invalid command');
        }

        $author = $this->authorRepository->findById(
            new AuthorId($command->authorId())
        );

        if ($author === null) {
            throw new AuthorNotFoundException();
        }

        $book = new Book(
            $this->bookRepository->nextIdentity(),
            new BookTitle($command->bookTitle()),
            $author,
        );

        $this->bookRepository->save($book);

        $this->eventBus->publish(new BookCreatedEvent(
            $book->bookId(),
            $book->bookTitle(),
            $book->author()->authorId(),
            $book->author()->authorName(),
        ));

        return $book->bookId()->value();
    }
}
