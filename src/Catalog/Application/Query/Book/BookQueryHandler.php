<?php

namespace Catalog\Application\Query\Book;

use Catalog\Domain\Model\Book\BookQueryRepository;
use Shared\Application\Query\Query;
use Shared\Application\Query\QueryHandler;

abstract class BookQueryHandler implements QueryHandler
{
    protected BookQueryRepository $bookRepository;

    public function __construct(BookQueryRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    abstract public function handle(Query $query): mixed;
}
