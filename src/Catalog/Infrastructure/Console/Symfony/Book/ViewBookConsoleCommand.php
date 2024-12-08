<?php

namespace Catalog\Infrastructure\Console\Symfony\Book;

use Catalog\Application\Query\Book\View\ViewBookQuery;
use Psr\Log\LoggerInterface;
use Shared\Application\Query\QueryBus;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;

class ViewBookConsoleCommand extends ConsoleCommand
{
    private QueryBus $queryBus;

    public function __construct(LoggerInterface $logger, QueryBus $queryBus)
    {
        parent::__construct($logger);
        $this->queryBus = $queryBus;
    }

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

        $table = new Table($this->output);

        foreach ($book as $k => $v) {
            $table->addRow([$k, $v]);
        }

        $this->output->writeln("");
        $table->render();
        $this->output->writeln("");
    }
}
