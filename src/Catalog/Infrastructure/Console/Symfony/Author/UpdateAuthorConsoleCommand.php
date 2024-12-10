<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Command\Author\Update\UpdateAuthorCommand;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class UpdateAuthorConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('author:update')
            ->setDescription('Update an author')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID')
            ->addArgument('author_name', InputArgument::REQUIRED, 'The author name');
    }

    protected function executeCommand(): void
    {
        $this->commandBus->dispatch(
            new UpdateAuthorCommand(
                $this->input->getArgument('author_id'),
                $this->input->getArgument('author_name'),
            )
        );

        $this->outputMessage("Author updated");
    }
}
