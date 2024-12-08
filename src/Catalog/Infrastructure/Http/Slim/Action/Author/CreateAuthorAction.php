<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Command\Author\Create\CreateAuthorCommand;
use InvalidArgumentException;
use Shared\Application\Command\CommandBus;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CreateAuthorAction extends Action
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
        $formData = $this->formData();
        $this->validateFormData($formData);

        $authorId = uniqid();

        $this->commandBus->dispatch(new CreateAuthorCommand(
            $authorId,
            $formData['author_name'],
        ));

        $this->logger->info("Author was created.", [
            'author_id' => $authorId,
            'author_name' => $formData['author_name'],
        ]);

        return $this->response
            ->withHeader('Location', "/authors/$authorId")
            ->withStatus(201);
    }

    /**
     * @param array<mixed> $formData
     */
    private function validateFormData(array $formData): void
    {
        if (!isset($formData['author_name'])) {
            throw new InvalidArgumentException('Field `author_name` is required');
        }
    }
}
