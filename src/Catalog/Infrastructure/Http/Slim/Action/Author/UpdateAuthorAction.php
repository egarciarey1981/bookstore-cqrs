<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Command\Author\Update\UpdateAuthorCommand;
use Shared\Application\Command\CommandBus;
use Shared\Domain\Exception\InvalidDataException;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class UpdateAuthorAction extends Action
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

        $this->commandBus->dispatch(new UpdateAuthorCommand(
            $this->args['author_id'],
            $formData['author_name'],
        ));

        $this->logger->info(
            'Author was updated.',
            array_merge($formData, $this->args),
        );

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
                'method' => __METHOD__,
                'payload' => $formData,
            ]);
        }
    }
}