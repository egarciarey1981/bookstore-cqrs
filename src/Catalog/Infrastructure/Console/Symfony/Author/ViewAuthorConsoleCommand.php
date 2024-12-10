<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class ViewAuthorConsoleCommand extends ConsoleCommand
{
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

        $this->outputRow($author);
    }
}
