<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Psr\Log\LoggerInterface;
use Shared\Application\Query\QueryBus;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;

class ViewAuthorConsoleCommand extends ConsoleCommand
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
            ->setName('author:view')
            ->setDescription('View a author by ID')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID');
    }

    protected function executeCommand(): void
    {
        $author = $this->queryBus->ask(
            new ViewAuthorQuery(
                $this->input->getArgument('author_id'),
            )
        );

        $table = new Table($this->output);

        foreach ($author as $k => $v) {
            $table->addRow([$k, $v]);
        }

        $this->output->writeln("");
        $table->render();
        $this->output->writeln("");
    }
}
