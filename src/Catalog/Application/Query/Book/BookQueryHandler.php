<?php

namespace Catalog\Application\Query\Book;

use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Shared\Application\Query\Query;
use Shared\Application\Query\QueryHandler;

abstract class BookQueryHandler implements QueryHandler
{
    protected AuthorQueryRepository $bookRepository;

    public function __construct(AuthorQueryRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    abstract public function handle(Query $query): mixed;
}
