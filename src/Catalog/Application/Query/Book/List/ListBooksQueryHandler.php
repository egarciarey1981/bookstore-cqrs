<?php

namespace Catalog\Application\Query\Book\List;

use Catalog\Application\Query\Book\BookQueryHandler;
use Shared\Application\Query\Query;
use Exception;

class ListBooksQueryHandler extends BookQueryHandler
{
    /**
     * @return array<mixed>
     */
    public function handle(Query $query): array
    {
        if (!$query instanceof ListBooksQuery) {
            throw new Exception('Invalid query');
        }

        return $this->bookRepository->findAll(
            $query->page(),
            $query->limit(),
            $query->sort(),
            $query->order(),
        );
    }
}
