<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Book;

use Catalog\Application\Command\Book\Delete\DeleteBookCommand;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class DeleteBookAction extends Action
{
    private CommandBus $commandBus;

    public function __construct(
        LoggerInterface $logger,
        CommandBus $commandBus,
    ) {
        parent::__construct($logger);
        $this->commandBus = $commandBus;
    }

    public function action(): Response
    {
        $this->commandBus->dispatch(new DeleteBookCommand(
            $this->args['book_id'],
        ));

        $this->logger->info("Book was deleted.", $this->args);

        return $this->response->withStatus(204);
    }
}
