<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Query\Book\List\ListBooksQuery;
use Exception;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption('page', null, InputOption::VALUE_OPTIONAL, 'Page', 1)
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limit', 10)
            ->addOption('sort', null, InputOption::VALUE_OPTIONAL, 'Sort', 'book_title')
            ->addOption('order', null, InputOption::VALUE_OPTIONAL, 'Order', 'asc');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $books = $this->queryBus->ask(
                new ListBooksQuery(
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

        if (empty($books)) {
            $output->writeln("\n<error> No books found </error>\n");
            return Command::SUCCESS;
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
