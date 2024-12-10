<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Command\Book\Delete\DeleteBookCommand;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class DeleteBookConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('book:delete')
            ->setDescription('Delete a book by ID')
            ->addArgument('book_id', InputArgument::REQUIRED, 'The book ID');
    }

    protected function executeCommand(): void
    {
        $this->commandBus->dispatch(
            new DeleteBookCommand(
                $this->input->getArgument('book_id'),
            )
        );

        $this->outputMessage("Book deleted");
    }
}
