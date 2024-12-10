<?php

namespace Catalog\Application\Query\Author\View;

use Catalog\Application\Query\Author\AuthorQueryHandler;
use Catalog\Domain\Model\Author\AuthorNotFoundException;
use Shared\Application\Query\Query;
use Exception;

class ViewAuthorQueryHandler extends AuthorQueryHandler
{
    /**
     * @return array<mixed>
     */
    public function handle(Query $query): array
    {
        if (!$query instanceof ViewAuthorQuery) {
            throw new Exception('Invalid query.');
        }

        $author = $this->authorRepository->findById($query->authorId());

        if (null === $author) {
            throw new AuthorNotFoundException();
        }

        return $author->toArray();
    }
}
