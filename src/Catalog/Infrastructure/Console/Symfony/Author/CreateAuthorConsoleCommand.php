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
        $authorId = uniqid();
        $arguments = $this->input->getArguments();

        $this->commandBus->dispatch(
            new CreateAuthorCommand(
                $authorId,
                $arguments['author_name'],
            )
        );

        $this->logger->info("Author was created.", [
            'author_id' => $authorId,
            'author_name' => $arguments['author_name'],
        ]);

        $this->output->writeln("\n<info>Author created with ID: $authorId\n</info>");
    }
}
