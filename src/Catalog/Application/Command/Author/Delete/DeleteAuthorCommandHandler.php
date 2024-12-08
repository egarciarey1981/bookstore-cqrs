<?php

namespace Catalog\Application\Command\Author\Delete;

use Catalog\Application\Command\Author\AuthorCommandHandler;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Event\Author\AuthorDeletedEvent;
use Shared\Domain\Model\Author\AuthorId;

class DeleteAuthorCommandHandler extends AuthorCommandHandler
{
    public function handle(Command $command): void
    {
        if (!$command instanceof DeleteAuthorCommand) {
            throw new Exception('Invalid command');
        }

        $authorId = new AuthorId($command->authorId());

        $author = $this->authorRepository->findById($authorId);

        if ($author === null) {
            throw new AuthorNotFoundException();
        }

        $this->authorRepository->delete($authorId);

        $this->eventBus->publish(new AuthorDeletedEvent(
            $authorId,
        ));
    }
}
