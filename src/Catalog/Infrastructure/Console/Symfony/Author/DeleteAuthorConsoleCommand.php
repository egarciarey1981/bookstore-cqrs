<?php

namespace Catalog\Infrastructure\Console\Symfony\Author;

use Catalog\Application\Command\Author\Delete\DeleteAuthorCommand;
use Exception;
use Shared\Application\Command\CommandBus;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteAuthorConsoleCommand extends Command
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('author:delete')
            ->setDescription('Delete a author by ID')
            ->addArgument('author_id', InputArgument::REQUIRED, 'The author ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
             $this->commandBus->dispatch(
                new DeleteAuthorCommand(
                    $input->getArgument('author_id'),
                )
            );
        } catch (Exception $exception) {
            $output->writeln("\n<error> ERROR: {$exception->getMessage()} </error>\n");
            return Command::FAILURE;
        }

        $output->writeln("\n<info> Author deleted </info>\n");

        return Command::SUCCESS;
    }
}
