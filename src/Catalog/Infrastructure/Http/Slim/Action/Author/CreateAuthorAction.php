<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Command\Author\Create\CreateAuthorCommand;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Shared\Infrastructure\Http\Slim\Action\Action;

class CreateAuthorAction extends Action
{
    protected function action(): ResponseInterface
    {
        $formData = $this->request->getParsedBody();
        assert(is_array($formData));

        if (!isset($formData['author_name'])) {
            throw new InvalidArgumentException('Field `author_name` is required');
        }

        $authorId = $this->commandBus->dispatch(new CreateAuthorCommand(
            $formData['author_name'],
        ));

        $this->logger->info(
            'Author was created.',
            array_merge($formData, ['author_id' => $authorId]),
        );  

        return $this->response
            ->withHeader('Location', "/authors/$authorId")
            ->withStatus(201);
    }
}
