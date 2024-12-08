<?php

namespace Catalog\Application\Query\Book\View;

use Catalog\Application\Query\Book\BookQueryHandler;
use Catalog\Domain\Model\Book\BookNotFoundException;
use Shared\Application\Query\Query;
use Exception;

class ViewBookQueryHandler extends BookQueryHandler
{
    /**
     * @return array<mixed>
     */
    public function handle(Query $query): array
    {
        if (!$query instanceof ViewBookQuery) {
            throw new Exception('Invalid query');
        }

        $book = $this->bookRepository->findById($query->bookId());

        if (null === $book) {
            throw new BookNotFoundException();
        }

        return $book;
    }
}
