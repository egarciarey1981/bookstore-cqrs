<?php

namespace Bookstore\Catalog\Infrastructure\Http\Slim\Action\Book;

use Bookstore\Catalog\Application\Query\Book\List\ListBooksQuery;
use Bookstore\Shared\Infrastructure\Http\Slim\Action\Action;
use Bookstore\Shared\Application\Query\QueryBus;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListBooksAction extends Action
{
    private QueryBus $queryBus;

    public function __construct(
        LoggerInterface $logger,
        QueryBus $queryBus,
    ) {
        parent::__construct($logger);
        $this->queryBus = $queryBus;
    }

    public function action(): Response
    {
        $queryParams = $this->request->getQueryParams();

        $books = $this->queryBus->ask(new ListBooksQuery(
            $queryParams['page'] ?? 1,
            $queryParams['limit'] ?? 10,
        ));

        $this->response->getBody()->write(json_encode([
            'books' => $books,
        ]));

        $this->logger->info("Books were viewed.", $queryParams);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
