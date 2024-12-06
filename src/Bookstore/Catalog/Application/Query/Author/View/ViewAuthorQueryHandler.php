<?php

namespace Bookstore\Catalog\Application\Query\Author\View;

use Bookstore\Catalog\Domain\Model\Author\AuthorNotFoundException;
use Bookstore\Catalog\Domain\Model\Author\AuthorQueryRepository;
use Bookstore\Shared\Application\Query\Query;
use Bookstore\Shared\Application\Query\QueryHandler;
use Exception;

class ViewAuthorQueryHandler implements QueryHandler
{
    private AuthorQueryRepository $authorRepository;

    public function __construct(AuthorQueryRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle(Query $query): array
    {
        if (!$query instanceof ViewAuthorQuery) {
            throw new Exception('Invalid query.');
        }

        $author = $this->authorRepository->findById(
            $query->authorId(),
        );

        if (null === $author) {
            throw new AuthorNotFoundException(
                'Author not found.',
                ['author_id' => $query->authorId()],
            );
        }

        return $author;
    }
}
