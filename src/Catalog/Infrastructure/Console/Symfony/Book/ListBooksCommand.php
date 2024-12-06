<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Query\Book\List\ListBooksQuery;
use Exception;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListBooksCommand extends Command
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
            ->setName('book:list')
            ->setDescription('List books')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page', 1)
            ->addArgument('limit', InputArgument::OPTIONAL, 'Limit', 10)
            ->addArgument('sort', InputArgument::OPTIONAL, 'Sort', 'book_title')
            ->addArgument('order', InputArgument::OPTIONAL, 'Order', 'asc');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $books = $this->queryBus->ask(
                new ListBooksQuery(
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

        $headers = array_keys($books[0]);

        $table->setHeaders($headers);

        foreach ($books as $book) {
            $row = [];
            foreach ($headers as $header) {
                $row[] = $book[$header];
            }
            $table->addRow($row);
        }

        $output->writeln("");
        $table->render();
        $output->writeln("");

        return Command::SUCCESS;
    }
}
