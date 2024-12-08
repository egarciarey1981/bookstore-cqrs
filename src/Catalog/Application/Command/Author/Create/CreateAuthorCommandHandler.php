<?php

namespace Catalog\Application\Command\Author\Create;

use Catalog\Application\Command\Author\AuthorCommandHandler;
use Catalog\Domain\Model\Author\Author;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Author\AuthorCreatedEvent;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Author\AuthorName;

class CreateAuthorCommandHandler extends AuthorCommandHandler
{
    public function handle(Command $command): void
    {
        if (!$command instanceof CreateAuthorCommand) {
            throw new Exception('Invalid command');
        }

        $authorId = new AuthorId($command->authorId());
        $authorName = new AuthorName($command->authorName());

        $this->authorRepository->save(new Author(
            $authorId,
            $authorName,
        ));

        $this->eventBus->publish(new AuthorCreatedEvent(
            $authorId,
            $authorName,
        ));
    }
}
