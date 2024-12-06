<?php

namespace Bookstore\Catalog\Application\Command\Author\Create;

use Bookstore\Catalog\Domain\Model\Author\Author;
use Bookstore\Catalog\Domain\Model\Author\AuthorCommandRepository;
use Bookstore\Shared\Application\Command\Command;
use Bookstore\Shared\Application\Command\CommandHandler;
use Bookstore\Shared\Domain\Model\Author\AuthorName;
use InvalidArgumentException;

class CreateAuthorCommandHandler implements CommandHandler
{
    private AuthorCommandRepository $authorRepository;

    public function __construct(AuthorCommandRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Command $command): void
    {
        if (!$command instanceof CreateAuthorCommand) {
            throw new InvalidArgumentException('Invalid command');
        }

        $this->authorRepository->save(
            new Author(
                $this->authorRepository->nextIdentity(),
                new AuthorName($command->authorName())
            )
        );
    }
}
