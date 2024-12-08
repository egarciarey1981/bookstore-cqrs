<?php

namespace Catalog\Application\Command\Author;

use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\EventBus;

abstract class AuthorCommandHandler implements CommandHandler
{
    protected AuthorCommandRepository $authorRepository;
    protected EventBus $eventBus;

    public function __construct(
        AuthorCommandRepository $authorRepository,
        EventBus $eventBus,
    ) {
        $this->authorRepository = $authorRepository;
        $this->eventBus = $eventBus;
    }

    abstract public function handle(Command $command): void;
}
