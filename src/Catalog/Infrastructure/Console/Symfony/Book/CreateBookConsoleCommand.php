<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Command\Book\Create\CreateBookCommand;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class CreateBookConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('book:create')
            ->setDescription('Create a book')
            ->addArgument('book_title', InputArgument::REQUIRED, 'The book title')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID');
    }

    protected function executeCommand(): void
    {
        $bookId = $this->commandBus->dispatch(
            new CreateBookCommand(
                $this->input->getArgument('book_title'),
                $this->input->getArgument('author_id'),
            )
        );

        $this->outputMessage("Book created: $bookId");
    }
}
