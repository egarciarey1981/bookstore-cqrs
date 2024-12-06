<?php

namespace Bookstore\Catalog\Application\Command\Book\Create;

use Bookstore\Catalog\Domain\Model\Author\AuthorCommandRepository;
use Bookstore\Catalog\Domain\Model\Book\Book;
use Bookstore\Catalog\Domain\Model\Book\BookCommandRepository;
use Bookstore\Shared\Application\Command\Command;
use Bookstore\Shared\Application\Command\CommandHandler;
use Bookstore\Shared\Domain\Exception\InvalidDataException;
use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Book\BookTitle;
use InvalidArgumentException;

class CreateBookCommandHandler implements CommandHandler
{
    private AuthorCommandRepository $authorCommandRepository;
    private BookCommandRepository $bookCommandRepository;

    public function __construct(
        AuthorCommandRepository $authorCommandRepository,
        BookCommandRepository $bookCommandRepository,
    ) {
        $this->authorCommandRepository = $authorCommandRepository;
        $this->bookCommandRepository = $bookCommandRepository;
    }

    public function handle(Command $command): void
    {
        if (!$command instanceof CreateBookCommand) {
            throw new InvalidArgumentException('Invalid command');
        }

        $author = $this->authorCommandRepository->findById(
            new AuthorId($command->authorId())
        );

        if ($author === null) {
            throw new InvalidDataException(
                'Author not found',
                [
                    'class' => __CLASS__,
                    'payload' => $command,
                ],
            );
        }

        $this->bookCommandRepository->save(
            new Book(
                $this->bookCommandRepository->nextIdentity(),
                new BookTitle($command->bookTitle()),
                $author,
            )
        );
    }
}
