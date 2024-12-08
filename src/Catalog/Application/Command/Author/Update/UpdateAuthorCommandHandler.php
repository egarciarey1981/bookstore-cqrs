<?php

namespace Catalog\Application\Command\Author\Update;

use Catalog\Application\Command\Author\AuthorCommandHandler;
use Catalog\Domain\Model\Author\Author;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Author\AuthorUpdatedEvent;
use Shared\Domain\Model\Author\AuthorName;
use Shared\Domain\Model\Author\AuthorId;

class UpdateAuthorCommandHandler extends AuthorCommandHandler
{
    public function handle(Command $command): mixed
    {
        if (!$command instanceof UpdateAuthorCommand) {
            throw new Exception('Invalid command');
        }

        $authorId = new AuthorId($command->authorId());
        $authorName = new AuthorName($command->authorName());

        $author = $this->authorRepository->findById($authorId);

        if ($author === null) {
            throw new AuthorNotFoundException();
        }

        $this->authorRepository->save(new Author(
            $authorId,
            $authorName,
        ));

        $this->eventBus->publish(new AuthorUpdatedEvent(
            $authorId,
            $authorName,
        ));

        return null;
    }
}
