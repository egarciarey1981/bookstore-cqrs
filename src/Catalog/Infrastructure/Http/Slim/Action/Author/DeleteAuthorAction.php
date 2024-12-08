<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Command\Author\Delete\DeleteAuthorCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Shared\Infrastructure\Http\Slim\Action\Action;

class DeleteAuthorAction extends Action
{
    public function action(): Response
    {
        $this->commandBus->dispatch(
            new DeleteAuthorCommand(
                $this->args['author_id'],
            )
        );

        $this->logger->info('Author was deleted.', $this->args);

        return $this->response->withStatus(204);
    }
}
