<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputOption;

class ListAuthorsConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('author:list')
            ->setDescription('List authors')
            ->addOption('page', null, InputOption::VALUE_OPTIONAL, 'Page', 1)
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limit', 10)
            ->addOption('sort', null, InputOption::VALUE_OPTIONAL, 'Sort', 'author_name')
            ->addOption('order', null, InputOption::VALUE_OPTIONAL, 'Order', 'asc');
    }

    protected function executeCommand(): void
    {
        $authors = $this->queryBus->ask(
            new ListAuthorsQuery(
                $this->input->getOption('page'),
                $this->input->getOption('limit'),
                $this->input->getOption('sort'),
                $this->input->getOption('order'),
            )
        );

        $this->outputTable($authors);
    }
}
