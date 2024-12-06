<?php

namespace Bookstore\Catalog\Application\Command\Author\Create;

use Bookstore\Catalog\Domain\Model\Author\Author;
use Bookstore\Catalog\Domain\Model\Author\AuthorCommandRepository;
use Bookstore\Shared\Application\Command\Command;
use Bookstore\Shared\Application\Command\CommandHandler;
use Bookstore\Shared\Application\Event\Author\AuthorCreatedEvent;
use Bookstore\Shared\Application\Event\EventBus;
use Bookstore\Shared\Domain\Model\Author\AuthorName;
use Exception;

class CreateAuthorCommandHandler implements CommandHandler
{
    private AuthorCommandRepository $authorRepository;
    private EventBus $eventBus;

    public function __construct(
        AuthorCommandRepository $authorRepository,
        EventBus $eventBus,
    ) {
        $this->authorRepository = $authorRepository;
        $this->eventBus = $eventBus;
    }

    public function handle(Command $command): void
    {
        if (!$command instanceof CreateAuthorCommand) {
            throw new Exception('Invalid command');
        }

        $author = new Author(
            $this->authorRepository->nextIdentity(),
            new AuthorName($command->authorName())
        );

        $this->authorRepository->save($author);

        $this->eventBus->publish(new AuthorCreatedEvent(
            $author->authorId(),
            $author->authorName(),
        ));
    }
}
