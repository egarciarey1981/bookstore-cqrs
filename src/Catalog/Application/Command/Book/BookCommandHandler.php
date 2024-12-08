<?php

namespace Catalog\Application\Command\Book;

use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Catalog\Domain\Model\Book\BookCommandRepository;
use Shared\Application\Command\Command;
use Shared\Application\Command\CommandHandler;
use Shared\Application\Event\EventBus;

abstract class BookCommandHandler implements CommandHandler
{
    protected AuthorCommandRepository $authorRepository;
    protected BookCommandRepository $bookRepository;
    protected EventBus $eventBus;

    public function __construct(
        AuthorCommandRepository $authorRepository,
        BookCommandRepository $bookRepository,
        EventBus $eventBus,
    ) {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
        $this->eventBus = $eventBus;
    }

    abstract public function handle(Command $command): void;
}
