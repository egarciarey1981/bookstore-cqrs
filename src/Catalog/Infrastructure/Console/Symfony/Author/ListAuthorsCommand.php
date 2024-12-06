<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Exception;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAuthorsCommand extends Command
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
            ->addArgument('page', InputArgument::OPTIONAL, 'Page', 1)
            ->addArgument('limit', InputArgument::OPTIONAL, 'Limit', 10)
            ->addArgument('sort', InputArgument::OPTIONAL, 'Sort', 'author_name')
            ->addArgument('order', InputArgument::OPTIONAL, 'Order', 'asc');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $authors = $this->queryBus->ask(
                new ListAuthorsQuery(
                    $input->getArgument('page'),
                    $input->getArgument('limit'),
                    $input->getArgument('sort'),
                    $input->getArgument('order'),
                )
            );
        } catch (Exception $exception) {
            $output->writeln("\n<error> ERROR: {$exception->getMessage()} </error>\n");
            return Command::FAILURE;
        }

        $table = new Table($output);

        $table->setHeaders(['author_id', 'author_name']);

        foreach ($authors as $author) {
            $table->addRow([
                $author['author_id'],
                $author['author_name'],
            ]);
        }

        $output->writeln("");
        $table->render();
        $output->writeln("");

        return Command::SUCCESS;
    }
}
