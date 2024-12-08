<?php

namespace Catalog\Application\Command\Book\Create;

use Catalog\Application\Command\Book\BookCommandHandler;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Catalog\Domain\Model\Book\Book;
use Catalog\Domain\Model\Book\BookNotFoundException;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Book\BookCreatedEvent;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Book\BookTitle;
use Shared\Domain\Model\Book\BookId;

class CreateBookCommandHandler extends BookCommandHandler
{
    public function handle(Command $command): void
    {
        if (!$command instanceof CreateBookCommand) {
            throw new Exception('Invalid command');
        }

        $bookId = new BookId($command->bookId());
        $bookTitle = new BookTitle($command->bookTitle());
        $authorId = new AuthorId($command->authorId());

        $book = $this->bookRepository->findById($bookId);

        if ($book === null) {
            throw new BookNotFoundException();
        }

        $author = $this->authorRepository->findById($authorId);

        if ($author === null) {
            throw new AuthorNotFoundException();
        }

        $book = new Book(
            $bookId,
            $bookTitle,
            $author,
        );

        $this->bookRepository->save($book);

        $this->eventBus->publish(new BookCreatedEvent(
            $book->bookId(),
            $book->bookTitle(),
            $book->author()->authorId(),
            $book->author()->authorName(),
        ));
    }
}
