<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Command\Author\Update\UpdateAuthorCommand;
use Psr\Log\LoggerInterface;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class UpdateAuthorConsoleCommand extends ConsoleCommand
{
    private CommandBus $commandBus;

    public function __construct(LoggerInterface $logger, CommandBus $commandBus)
    {
        parent::__construct($logger);
        $this->commandBus = $commandBus;
    }

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

        $this->output->writeln("\n<info>Author updated successfully</info>\n");
    }
}
