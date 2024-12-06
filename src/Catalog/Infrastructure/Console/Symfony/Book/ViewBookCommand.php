<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Query\Book\View\ViewBookQuery;
use Exception;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewBookCommand extends Command
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
            ->setName('book:view')
            ->setDescription('View a book by ID')
            ->addArgument('book_id', InputArgument::REQUIRED, 'The book ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $book = $this->queryBus->ask(
                new ViewBookQuery(
                    $input->getArgument('book_id'),
                )
            );
        } catch (Exception $exception) {
            $output->writeln("\n<error> ERROR: {$exception->getMessage()} </error>\n");
            return Command::FAILURE;
        }

        $table = new Table($output);

        foreach ($book as $k => $v) {
            $table->addRow([$k, $v]);
        }

        $output->writeln("");
        $table->render();
        $output->writeln("");

        return Command::SUCCESS;
    }
}
