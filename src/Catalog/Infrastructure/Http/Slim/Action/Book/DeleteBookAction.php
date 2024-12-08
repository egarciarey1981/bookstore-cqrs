<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Book;

use Catalog\Application\Command\Book\Delete\DeleteBookCommand;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteBookAction extends Action
{
    public function action(): Response
    {
        $this->commandBus->dispatch(new DeleteBookCommand(
            $this->args['book_id'],
        ));

        $this->logger->info("Book was deleted.", $this->args);

        return $this->response->withStatus(204);
    }
}
