<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Book;

use Catalog\Application\Command\Book\Update\UpdateBookCommand;
use Shared\Domain\Exception\InvalidDataException;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateBookAction extends Action
{
    public function action(): Response
    {
        $formData = $this->request->getParsedBody();
        assert(is_array($formData));

        if (!isset($formData['book_title'])) {
            throw new InvalidDataException('Field `book_title` is required');
        } elseif (!isset($formData['author_id'])) {
            throw new InvalidDataException('Field `author_id` is required');
        }

        $this->commandBus->dispatch(new UpdateBookCommand(
            $this->args['book_id'],
            $formData['book_title'],
            $formData['author_id'],
        ));

        $this->logger->info(
            'Book was created.',
            array_merge($formData, $this->args),
        );

        return $this->response->withStatus(204);
    }
}
