<?php

namespace Bookstore\Catalog\Application\Query\Book\View;

use Bookstore\Catalog\Domain\Model\Book\BookNotFoundException;
use Bookstore\Catalog\Domain\Model\Book\BookQueryRepository;
use Bookstore\Shared\Application\Query\Query;
use Bookstore\Shared\Application\Query\QueryHandler;
use Exception;

class ViewBookQueryHandler implements QueryHandler
{
    private BookQueryRepository $bookRepository;

    public function __construct(BookQueryRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(Query $query): array
    {
        if (!$query instanceof ViewBookQuery) {
            throw new Exception('Invalid query');
        }

        $book = $this->bookRepository->findById($query->bookId());

        if (null === $book) {
            throw new BookNotFoundException('Book not found.', [
                'book_id' => $query->bookId(),
            ]);
        }

        return $book;
    }
}
