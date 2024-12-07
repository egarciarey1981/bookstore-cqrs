<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Command\Author\Delete\DeleteAuthorCommand;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class DeleteAuthorAction extends Action
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
        $this->commandBus->dispatch(new DeleteAuthorCommand(
            $this->args['author_id'],
        ));

        $this->logger->info("Author was deleted.", $this->args);

        return $this->response->withStatus(204);
    }
}
