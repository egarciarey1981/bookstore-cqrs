<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Query\Author\List\ListAuthorsQuery;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Shared\Application\Query\QueryBus;
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
        $queryParams = $this->request->getQueryParams();

        $authors = $this->queryBus->ask(new ListAuthorsQuery(
            $queryParams['page'] ?? 1,
            $queryParams['limit'] ?? 10,
        ));

        $this->response->getBody()->write(json_encode([
            'authors' => $authors,
        ]));

        $this->logger->info("Authors were viewed.", $queryParams);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}