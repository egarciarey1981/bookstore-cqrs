<?php

namespace Bookstore\Catalog\Infrastructure\Http\Slim\Action\Book;

use Bookstore\Catalog\Application\Query\Book\View\ViewBookQuery;
use Bookstore\Shared\Infrastructure\Http\Slim\Action\Action;
use Bookstore\Shared\Application\Query\QueryBus;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewBookAction extends Action
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
        $book = $this->queryBus->ask(
            new ViewBookQuery(
                $this->args['book_id']
            )
        );

        $this->response->getBody()->write(json_encode([
            'book' => $book,
        ]));

        $this->logger->info("Book was viewed.", $this->args);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
