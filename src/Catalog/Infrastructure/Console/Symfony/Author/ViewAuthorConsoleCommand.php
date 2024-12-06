<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Exception;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewAuthorConsoleCommand extends Command
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
            ->setName('author:view')
            ->setDescription('View a author by ID')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $author = $this->queryBus->ask(
                new ViewAuthorQuery(
                    $input->getArgument('author_id'),
                )
            );
        } catch (Exception $exception) {
            $output->writeln("\n<error> ERROR: {$exception->getMessage()} </error>\n");
            return Command::FAILURE;
        }

        $table = new Table($output);

        foreach ($author as $k => $v) {
            $table->addRow([$k, $v]);
        }

        $output->writeln("");
        $table->render();
        $output->writeln("");

        return Command::SUCCESS;
    }
}
