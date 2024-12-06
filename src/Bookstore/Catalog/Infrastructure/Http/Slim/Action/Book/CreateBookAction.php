<?php

namespace Bookstore\Catalog\Infrastructure\Http\Slim\Action\Book;

use Bookstore\Catalog\Application\Command\Book\Create\CreateBookCommand;
use Bookstore\Shared\Application\Command\CommandBus;
use Bookstore\Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CreateBookAction extends Action
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
        $formData = $this->request->getParsedBody();

        $this->commandBus->dispatch(
            new CreateBookCommand(
                $formData['book_title'],
                $formData['author_id'],
            )
        );

        $this->logger->info("Book was created.", $formData);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(202);
    }
}
