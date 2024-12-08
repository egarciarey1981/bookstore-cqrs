<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Book;

use Catalog\Application\Query\Book\View\ViewBookQuery;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;

class ViewBookAction extends Action
{
    public function action(): Response
    {
        $book = $this->queryBus->ask(new ViewBookQuery(
            $this->args['book_id']
        ));

        $this->response->getBody()->write(json_encode([
            'book' => $book,
        ], JSON_THROW_ON_ERROR));

        $this->logger->info("Book was viewed.", $this->args);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
