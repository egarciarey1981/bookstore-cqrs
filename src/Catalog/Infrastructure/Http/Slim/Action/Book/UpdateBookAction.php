<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Book;

use Catalog\Application\Command\Book\Create\CreateBookCommand;
use Shared\Application\Command\CommandBus;
use Shared\Domain\Exception\InvalidDataException;
use Shared\Infrastructure\Http\Slim\Action\Action;
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
        assert(is_array($formData));

        $this->validateFormData($formData);

        $this->commandBus->dispatch(new CreateBookCommand(
            $formData['book_id'],
            $formData['book_title'],
            $formData['author_id'],
        ));

        $this->logger->info("Book was created.", $formData);

        return $this->response->withStatus(204);
    }

    /**
     * @param array<mixed> $formData
     */
    private function validateFormData(array $formData): void
    {
        if (!isset($formData['author_name'])) {
            throw new InvalidDataException('Field `author_name` is required', [
                'class' => __CLASS__,
                'payload' => $formData,
            ]);
        }
    }
}
