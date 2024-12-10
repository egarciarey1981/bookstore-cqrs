<?php

namespace Shared\Infrastructure\Console\Symfony;

use Psr\Log\LoggerInterface;
use Shared\Application\Command\CommandBus;
use Shared\Application\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

abstract class ConsoleCommand extends Command
{
    protected LoggerInterface $logger;
    protected QueryBus $queryBus;
    protected CommandBus $commandBus;
    protected InputInterface $input;
    protected OutputInterface $output;

    public function __construct(
        LoggerInterface $logger,
        QueryBus $queryBus,
        CommandBus $commandBus,
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        try {
            $this->executeCommand();
            return Command::SUCCESS;
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            $this->outputMessage($exception->getMessage(), 'error');
            return Command::FAILURE;
        }
    }

    abstract protected function executeCommand(): void;

    protected function outputTable(array $rows): void
    {
        $table = new Table($this->output);
        $table->setHeaders(array_keys($rows[0]));
        foreach ($rows as $row) {
            $table->addRow($row);
        }

        $this->output->writeln('');
        $table->render();
        $this->output->writeln('');
    }

    protected function outputRow(array $row): void
    {
        $table = new Table($this->output);
        $table->setHeaders(['Key', 'Value']);
        foreach ($row as $k => $v) {
            $table->addRow([$k, $v]);
        }

        $this->output->writeln('');
        $table->render();
        $this->output->writeln('');
    }

    protected function outputMessage(string $message, string $type = 'info'): void
    {
        $this->output->writeln(
            sprintf("\n<%s> %s </%s>\n", $type, $message, $type)
        );
    }
}
