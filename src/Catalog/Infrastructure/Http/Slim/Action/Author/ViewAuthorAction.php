<?php

namespace Catalog\Infrastructure\Http\Slim\Action\Author;

use Catalog\Application\Query\Author\View\ViewAuthorQuery;
use Psr\Http\Message\ResponseInterface as Response;
use Shared\Infrastructure\Http\Slim\Action\Action;

class ViewAuthorAction extends Action
{
    public function action(): Response
    {
        $author = $this->queryBus->ask(new ViewAuthorQuery(
            $this->args['author_id'],
        ));

        $this->response->getBody()->write(json_encode([
            'author' => $author,
        ], JSON_THROW_ON_ERROR));

        $this->logger->info('Author was viewed.', $this->args);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
