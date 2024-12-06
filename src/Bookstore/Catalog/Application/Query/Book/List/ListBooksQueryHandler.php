<?php

namespace Bookstore\Catalog\Application\Query\Book\List;

use Bookstore\Catalog\Domain\Model\Book\BookQueryRepository;
use Bookstore\Shared\Application\Query\Query;
use Bookstore\Shared\Application\Query\QueryHandler;
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
        );
    }
}
