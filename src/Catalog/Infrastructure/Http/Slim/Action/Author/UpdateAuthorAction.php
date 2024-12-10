<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Command\Author\Update\UpdateAuthorCommand;
use Shared\Domain\Exception\InvalidDataException;
use Psr\Http\Message\ResponseInterface as Response;
use Shared\Infrastructure\Http\Slim\Action\Action;

class UpdateAuthorAction extends Action
{
    public function action(): Response
    {
        $formData = $this->request->getParsedBody();
        assert(is_array($formData));

        if (!isset($formData['author_name'])) {
            throw new InvalidDataException('Field `author_name` is required');
        }

        $this->commandBus->dispatch(new UpdateAuthorCommand(
            $this->args['author_id'],
            $formData['author_name'],
        ));

        $this->logger->info(
            'Author was updated.',
            array_merge($this->args, $formData),
        );

        return $this->response->withStatus(204);
    }
}
