<?php

namespace Bookstore\Catalog\Infrastructure\Http\Slim\Action\Author;

use Bookstore\Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Bookstore\Shared\Infrastructure\Http\Slim\Action\Action;
use Bookstore\Shared\Application\Query\QueryBus;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListAuthorsAction extends Action
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
        $authors = $this->queryBus->ask(
            new ListAuthorsQuery(
                $this->request->getQueryParams()['page'] ?? 1,
                $this->request->getQueryParams()['limit'] ?? 10,
            )
        );

        $this->response->getBody()->write(json_encode([
            'authors' => $authors,
        ]));

        $this->logger->info("Authors were viewed.", $this->request->getQueryParams());

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
