<?php

namespace Catalog\Application\Command\Author\Update;

use Catalog\Domain\Model\Author\Author;
use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\Author\AuthorUpdatedEvent;
use Shared\Application\Event\EventBus;
use Shared\Domain\Model\Author\AuthorName;
use Exception;
use Shared\Domain\Model\Author\AuthorId;

class UpdateAuthorCommandHandler implements CommandHandler
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
        if (!$command instanceof UpdateAuthorCommand) {
            throw new Exception('Invalid command');
        }

        $this->assertAuthorExists($command);

        $author = new Author(
            new AuthorId($command->authorId()),
            new AuthorName($command->authorName()),
        );

        $this->authorRepository->save($author);

        $this->eventBus->publish(new AuthorUpdatedEvent(
            $author->authorId(),
            $author->authorName(),
        ));
    }

    private function assertAuthorExists(UpdateAuthorCommand $command): void
    {
        $author = $this->authorRepository->findById(
            new AuthorId($command->authorId())
        );

        if ($author === null) {
            throw new AuthorNotFoundException('Author not found', [
                'class' => __CLASS__,
                'payload' => $command->toArray(),
            ]);
        }
    }
}
