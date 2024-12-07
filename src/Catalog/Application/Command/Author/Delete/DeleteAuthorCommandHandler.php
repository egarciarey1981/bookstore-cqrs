<?php

namespace Catalog\Application\Command\Author\Delete;

use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Exception;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\Author\AuthorDeletedEvent;
use Shared\Application\Event\EventBus;
use Shared\Domain\Model\Author\AuthorId;

class DeleteAuthorCommandHandler implements CommandHandler
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
        if (!$command instanceof DeleteAuthorCommand) {
            throw new Exception('Invalid command');
        }

        $authorId = new AuthorId($command->getAuthorId());

        $this->authorRepository->delete($authorId);

        $this->eventBus->publish(
            new AuthorDeletedEvent($authorId)
        );
    }
}
