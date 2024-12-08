<?php

namespace Catalog\Application\Query\Author\List;

use Catalog\Application\Query\Author\AuthorQueryHandler;
use Shared\Application\Query\Query;
use Exception;

class ListAuthorsQueryHandler extends AuthorQueryHandler
{
    /**
     * @return array<mixed>
     */
    public function handle(Query $query): array
    {
        if (!$query instanceof ListAuthorsQuery) {
            throw new Exception('Invalid query');
        }

        return $this->authorRepository->findAll(
            $query->page(),
            $query->limit(),
            $query->sort(),
            $query->order()
        );
    }
}
