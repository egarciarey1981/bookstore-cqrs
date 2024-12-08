<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Book;

use Catalog\Application\Query\Book\List\ListBooksQuery;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;

class ListBooksAction extends Action
{
    public function action(): Response
    {
        $queryParams = $this->request->getQueryParams();

        $books = $this->queryBus->ask(new ListBooksQuery(
            $queryParams['page'] ?? 1,
            $queryParams['limit'] ?? 10,
            $queryParams['sort'] ?? 'book_title',
            $queryParams['order'] ?? 'asc',
        ));

        $this->response->getBody()->write(json_encode([
            'books' => $books,
        ], JSON_THROW_ON_ERROR));

        $this->logger->info("Books were viewed.", $queryParams);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
