<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Command\Author\Delete\DeleteAuthorCommand;
use Psr\Log\LoggerInterface;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class DeleteAuthorConsoleCommand extends ConsoleCommand
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
            ->setName('author:delete')
            ->setDescription('Delete a author by ID')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID');
    }

    protected function executeCommand(): void
    {
        $this->commandBus->dispatch(
            new DeleteAuthorCommand(
                $this->input->getArgument('author_id'),
            )
        );

        $this->output->writeln("\n<info> Author deleted </info>\n");
    }
}