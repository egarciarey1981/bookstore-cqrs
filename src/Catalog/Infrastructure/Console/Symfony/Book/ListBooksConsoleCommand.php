<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Query\Book\List\ListBooksQuery;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputOption;

class ListBooksConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('book:list')
            ->setDescription('List books')
            ->addOption('page', null, InputOption::VALUE_OPTIONAL, 'Page', 1)
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limit', 10)
            ->addOption('sort', null, InputOption::VALUE_OPTIONAL, 'Sort', 'book_title')
            ->addOption('order', null, InputOption::VALUE_OPTIONAL, 'Order', 'asc');
    }

    protected function executeCommand(): void
    {
        $books = $this->queryBus->ask(
            new ListBooksQuery(
                $this->input->getOption('page'),
                $this->input->getOption('limit'),
                $this->input->getOption('sort'),
                $this->input->getOption('order'),
            )
        );

        $this->outputTable($books);
    }
}
