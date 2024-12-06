<?php

namespace Catalog\Application\Query\Book\List;

use Catalog\Domain\Model\Book\BookQueryRepository;
use Shared\Application\Query\Query;
use Shared\Application\Query\QueryHandler;
use Exception;

class ListBooksQueryHandler implements QueryHandler
{
    private BookQueryRepository $bookRepository;

    public function __construct(BookQueryRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

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
