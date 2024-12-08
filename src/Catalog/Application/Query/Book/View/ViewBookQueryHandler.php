<?php

namespace Catalog\Application\Query\Book\View;

use Catalog\Domain\Model\Book\BookNotFoundException;
use Catalog\Domain\Model\Book\BookQueryRepository;
use Shared\Application\Query\Query;
use Shared\Application\Query\QueryHandler;
use Exception;

class ViewBookQueryHandler implements QueryHandler
{
    private BookQueryRepository $bookRepository;

    public function __construct(BookQueryRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

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
            throw new BookNotFoundException('Book not found.', [
                'class' => __CLASS__,
                'payload' => $query->toArray(),
            ]);
        }

        return $book;
    }
}
