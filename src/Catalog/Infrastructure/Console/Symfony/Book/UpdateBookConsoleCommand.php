<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Command\Book\Update\UpdateBookCommand;
use Psr\Log\LoggerInterface;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class UpdateBookConsoleCommand extends ConsoleCommand
{
    private CommandBus $commandBus;

    public function __construct(LoggerInterface $logger, CommandBus $commandBus)
    {
        parent::__construct($logger);
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('book:update')
            ->setDescription('Update a book')
            ->addArgument('book_id', InputArgument::REQUIRED, 'The book ID')
            ->addArgument('book_title', InputArgument::REQUIRED, 'The book title')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID');
    }

    protected function executeCommand(): void
    {
        $this->commandBus->dispatch(
            new UpdateBookCommand(
                $this->input->getArgument('book_id'),
                $this->input->getArgument('book_title'),
                $this->input->getArgument('author_id'),
            )
        );

        $this->output->writeln("\n<info>Book updated</info>\n");
    }
}
