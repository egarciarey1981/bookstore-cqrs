<?php

namespace Catalog\Application\Query\Author;

use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Shared\Application\Query\Query;
use Shared\Application\Query\QueryHandler;

abstract class AuthorQueryHandler implements QueryHandler
{
    protected AuthorQueryRepository $authorRepository;

    public function __construct(AuthorQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    abstract public function handle(Query $query): mixed;
}