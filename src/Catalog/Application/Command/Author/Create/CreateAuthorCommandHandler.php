<?php

namespace Catalog\Application\Command\Author\Create;

use Catalog\Application\Command\Author\AuthorCommandHandler;
use Catalog\Domain\Model\Author\Author;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Author\AuthorCreatedEvent;
use Shared\Domain\Model\Author\AuthorName;

class CreateAuthorCommandHandler extends AuthorCommandHandler
{
    public function handle(Command $command): string
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

        return $author->authorId()->value();
    }
}
