<?php

namespace Shared\Infrastructure\Console\Symfony;

use Psr\Log\LoggerInterface;
use Shared\Domain\Exception\InvalidDataException;
use Shared\Domain\Exception\ResourceNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

abstract class ConsoleCommand extends Command
{
    protected LoggerInterface $logger;
    protected InputInterface $input;
    protected OutputInterface $output;

    public function __construct(
        LoggerInterface $logger
    ) {
        parent::__construct();
        $this->logger = $logger;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        try {
            $this->executeCommand();
            return Command::SUCCESS;
        } catch (InvalidDataException | ResourceNotFoundException $exception) {
            $this->logger->error($exception->getMessage(), $exception->getContext());
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        $this->output->writeln("\n<error> ERROR: {$exception->getMessage()} </error>\n");

        return Command::FAILURE;
    }

    abstract protected function executeCommand(): void;
}
