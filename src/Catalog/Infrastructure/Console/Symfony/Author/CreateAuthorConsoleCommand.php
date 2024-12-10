<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Command\Author\Create\CreateAuthorCommand;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class CreateAuthorConsoleCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this
            ->setName('author:create')
            ->setDescription('Create an author')
            ->addArgument('author_name', InputArgument::REQUIRED, 'The author name');
    }

    protected function executeCommand(): void
    {
        $authorId = $this->commandBus->dispatch(
            new CreateAuthorCommand(
                $this->input->getArgument('author_name'),
            )
        );

        $this->outputMessage("Author created: $authorId");
    }
}
