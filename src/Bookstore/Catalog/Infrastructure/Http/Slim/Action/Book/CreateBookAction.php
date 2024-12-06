<?php

namespace Bookstore\Catalog\Infrastructure\Http\Slim\Action\Book;

use Bookstore\Catalog\Application\Command\Book\Create\CreateBookCommand;
use Bookstore\Shared\Application\Command\CommandBus;
use Bookstore\Shared\Domain\Exception\InvalidDataException;
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
        $this->validateFormData($formData);

        $this->commandBus->dispatch(new CreateBookCommand(
            $formData['book_title'],
            $formData['author_id'],
        ));

        $this->logger->info("Book was created.", $formData);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(202);
    }

    private function validateFormData(array $formData): void
    {
        if (!isset($formData['book_title'])) {
            throw new InvalidDataException('Field `book_title` is required', [
                'class' => __CLASS__,
                'payload' => $formData,
            ]);
        }

        if (!isset($formData['author_id'])) {
            throw new InvalidDataException('Field `author_id` is required', [
                'class' => __CLASS__,
                'payload' => $formData,
            ]);
        }
    }
}
