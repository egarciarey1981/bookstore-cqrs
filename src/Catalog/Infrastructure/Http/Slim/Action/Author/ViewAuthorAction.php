<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Shared\Infrastructure\Http\Slim\Action\Action;
use Shared\Application\Query\QueryBus;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewAuthorAction extends Action
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
        $author = $this->queryBus->ask(new ViewAuthorQuery(
            $this->args['author_id'],
        ));

        $this->response->getBody()->write(json_encode([
            'author' => $author,
        ]));

        $this->logger->info("Author was viewed.", $this->args);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
