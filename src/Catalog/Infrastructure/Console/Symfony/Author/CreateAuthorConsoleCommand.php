<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Command\Author\Create\CreateAuthorCommand;
use Psr\Log\LoggerInterface;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Console\Symfony\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;

class CreateAuthorConsoleCommand extends ConsoleCommand
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

        $this->logger->info("Author created: $authorId");

        $this->output->writeln("\n<info>Author created: $authorId\n</info>");
    }
}
