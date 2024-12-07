<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Exception;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListAuthorsConsoleCommand extends Command
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
    }

    protected function configure()
    {
        $this
            ->setName('author:list')
            ->setDescription('List authors')
            ->addOption('page', null, InputOption::VALUE_OPTIONAL, 'Page', 1)
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limit', 10)
            ->addOption('sort', null, InputOption::VALUE_OPTIONAL, 'Sort', 'book_title')
            ->addOption('order', null, InputOption::VALUE_OPTIONAL, 'Order', 'asc');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $authors = $this->queryBus->ask(
                new ListAuthorsQuery(
                    $input->getOption('page'),
                    $input->getOption('limit'),
                    $input->getOption('sort'),
                    $input->getOption('order'),
                )
            );
        } catch (Exception $exception) {
            $output->writeln("\n<error> ERROR: {$exception->getMessage()} </error>\n");
            return Command::FAILURE;
        }

        $table = new Table($output);

        $headers = array_keys($authors[0]);

        $table->setHeaders($headers);

        foreach ($authors as $author) {
            $row = [];
            foreach ($headers as $header) {
                $row[] = $author[$header];
            }
            $table->addRow($row);
        }

        $output->writeln("");
        $table->render();
        $output->writeln("");

        return Command::SUCCESS;
    }
}
