<?php

namespace Catalog\Application\Command\Book\Update;

use Catalog\Application\Command\Book\BookCommandHandler;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Catalog\Domain\Model\Book\Book;
use Catalog\Domain\Model\Book\BookNotFoundException;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Book\BookUpdatedEvent;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Book\BookId;
use Shared\Domain\Model\Book\BookTitle;

class UpdateBookCommandHandler extends BookCommandHandler
{
    public function handle(Command $command): void
    {
        if (!$command instanceof UpdateBookCommand) {
            throw new Exception('Invalid command');
        }

        $bookId = new BookId($command->bookId());
        $bookTitle = new BookTitle($command->bookTitle());
        $authorId = new AuthorId($command->authorId());

        $author = $this->authorRepository->findById($authorId);

        if ($author === null) {
            throw new AuthorNotFoundException();
        }

        $book = $this->bookRepository->findById($bookId);

        if ($book === null) {
            throw new BookNotFoundException();
        }

        $book = new Book(
            $bookId,
            $bookTitle,
            $author,
        );

        $this->bookRepository->save($book);

        $this->eventBus->publish(new BookUpdatedEvent(
            $book->bookId(),
            $book->bookTitle(),
            $book->author()->authorId(),
            $book->author()->authorName(),
        ));
    }
}
