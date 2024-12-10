<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Query\Book\View\ViewBookQuery;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;

class ViewBookConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('book:view')
            ->setDescription('View a book by ID')
            ->addArgument('book_id', InputArgument::REQUIRED, 'The book ID');
    }

    protected function executeCommand(): void
    {
        $book = $this->queryBus->ask(
            new ViewBookQuery(
                $this->input->getArgument('book_id'),
            )
        );

        $this->outputRow($book);
    }
}
