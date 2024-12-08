<?php

namespace Catalog\Application\Command\Book\Create;

use Catalog\Domain\Model\Author\Author;
use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Catalog\Domain\Model\Book\Book;
use Catalog\Domain\Model\Book\BookCommandRepository;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\Book\BookCreatedEvent;
use Shared\Application\Event\EventBus;
use Shared\Domain\Exception\InvalidDataException;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Book\BookTitle;
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

        $author = $this->assertAuthorExists($command);

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

    private function assertAuthorExists(CreateBookCommand $command): Author
    {
        $author = $this->authorCommandRepository->findById(
            new AuthorId($command->authorId())
        );

        if ($author === null) {
            throw new InvalidDataException('Author not found', [
                'class' => __CLASS__,
                'payload' => $command->toArray(),
            ]);
        }

        return $author;
    }
}
