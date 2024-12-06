<?php

namespace Catalog\Application\Command\Book\Update;

use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Catalog\Domain\Model\Book\Book;
use Catalog\Domain\Model\Book\BookCommandRepository;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\Book\BookUpdatedEvent;
use Shared\Application\Event\EventBus;
use Exception;
use Shared\Domain\Exception\InvalidDataException;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Book\BookId;
use Shared\Domain\Model\Book\BookTitle;

class UpdateBookCommandHandler implements CommandHandler
{
    private AuthorCommandRepository $authorRepository;
    private BookCommandRepository $bookRepository;
    private EventBus $eventBus;

    public function __construct(
        AuthorCommandRepository $authorRepository,
        BookCommandRepository $bookRepository,
        EventBus $eventBus,
    ) {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
        $this->eventBus = $eventBus;
    }

    public function handle(Command $command): void
    {
        if (!$command instanceof UpdateBookCommand) {
            throw new Exception('Invalid command');
        }

        $author = $this->authorRepository->findById(
            new AuthorId($command->authorId())
        );

        if ($author === null) {
            throw new InvalidDataException('Author not found', [
                'class' => __CLASS__,
                'method' => __METHOD__,
                'payload' => $command,
            ]);
        }

        $book = new Book(
            new BookId($command->bookId()),
            new BookTitle($command->bookTitle()),
            $author,
        );

        $this->bookRepository->save($book);

        $this->eventBus->publish(new BookUpdatedEvent(
            $book->bookId(),
            $book->bookTitle(),
            $author->authorId(),
            $author->authorName(),
        ));
    }
}
