<?php

namespace Bookstore\Catalog\Application\Command\Book\Create;

use Bookstore\Catalog\Domain\Model\Author\AuthorCommandRepository;
use Bookstore\Catalog\Domain\Model\Book\Book;
use Bookstore\Catalog\Domain\Model\Book\BookCommandRepository;
use Bookstore\Shared\Application\Command\Command;
use Bookstore\Shared\Application\Command\CommandHandler;
use Bookstore\Shared\Application\Event\Book\BookCreatedEvent;
use Bookstore\Shared\Application\Event\EventBus;
use Bookstore\Shared\Domain\Exception\InvalidDataException;
use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Book\BookTitle;
use Exception;

class CreateBookCommandHandler implements CommandHandler
{
    private AuthorCommandRepository $authorCommandRepository;
    private BookCommandRepository $bookCommandRepository;
    private EventBus $eventBus;

    public function __construct(
        AuthorCommandRepository $authorCommandRepository,
        BookCommandRepository $bookCommandRepository,
        EventBus $eventBus,
    ) {
        $this->authorCommandRepository = $authorCommandRepository;
        $this->bookCommandRepository = $bookCommandRepository;
        $this->eventBus = $eventBus;
    }

    public function handle(Command $command): void
    {
        if (!$command instanceof CreateBookCommand) {
            throw new Exception('Invalid command');
        }

        $author = $this->authorCommandRepository->findById(
            new AuthorId($command->authorId())
        );

        if ($author === null) {
            throw new InvalidDataException('Author not found', [
                'class' => __CLASS__,
                'payload' => $command,
            ]);
        }

        $book = new Book(
            $this->bookCommandRepository->nextIdentity(),
            new BookTitle($command->bookTitle()),
            $author,
        );

        $this->bookCommandRepository->save($book);

        $this->eventBus->publish(new BookCreatedEvent(
            $author->authorId(),
            $author->authorName(),
            $book->bookId(),
            $book->bookTitle(),
        ));
    }
}
