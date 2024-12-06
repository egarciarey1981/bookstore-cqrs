<?php

namespace Bookstore\Catalog\Application\Query\Author\List;

use Bookstore\Catalog\Domain\Model\Author\AuthorQueryRepository;
use Bookstore\Shared\Application\Query\Query;
use Bookstore\Shared\Application\Query\QueryHandler;
use Exception;

class ListAuthorsQueryHandler implements QueryHandler
{
    private AuthorQueryRepository $authorRepository;

    public function __construct(AuthorQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Query $query): array
    {
        if (!$query instanceof ListAuthorsQuery) {
            throw new Exception('Invalid query');
        }

        return $this->authorRepository->findAll(
            $query->page(),
            $query->limit(),
        );
    }
}
