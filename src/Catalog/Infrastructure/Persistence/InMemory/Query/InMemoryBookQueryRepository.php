<?php

namespace Catalog\Infrastructure\Persistence\InMemory\Query;

use Catalog\Domain\Model\Book\BookQueryRepository;
use Psr\Log\LoggerInterface;

class InMemoryBookQueryRepository implements BookQueryRepository
{
    private LoggerInterface $logger;
    private array $books = [];

    public function __construct(
        LoggerInterface $logger,
        array $books = null,
    ) {
        $this->logger = $logger;

        if (null === $books) {
            $books = $this->defaultBooks();
        }

        foreach ($books as $book) {
            $this->books[$book['book_id']] = $book;
        }
    }

    public function findAll(int $page, int $limit): array
    {
        return array_values(
            array_slice(
                $this->books,
                ($page - 1) * $limit,
                $limit,
            )
        );
    }

    public function findById(string $bookId): ?array
    {
        return $this->books[$bookId] ?? null;
    }

    public function save(array $book): void
    {
        $this->books[$book['book_id']] = $book;
        $this->logger->debug(
            'InMemoryBookQueryRepository::save',
            $book,
        );
    }

    public function delete(string $bookId): void
    {
        unset($this->books[$bookId]);
    }

    private function defaultBooks(): array
    {
        return [
            [
                'book_id' => 'sherlock',
                'book_title' => 'Sherlock Holmes',
                'author_id' => 'doyle',
                'author_name' => 'Arthur Conan Doyle',
            ],
            [
                'book_id' => 'lost_world',
                'book_title' => 'The Lost World',
                'author_id' => 'doyle',
                'author_name' => 'Arthur Conan Doyle',
            ],
            [
                'book_id' => 'mysterious',
                'book_title' => 'Mysterious Island',
                'author_id' => 'verne',
                'author_name' => 'Jules Verne',
            ],
            [
                'book_id' => 'around_the_world_in_80_days',
                'book_title' => 'Around the World in 80 Days',
                'author_id' => 'verne',
                'author_name' => 'Jules Verne',
            ],
            [
                'book_id' => 'treasure',
                'book_title' => 'Treasure Island',
                'author_id' => 'stevenson',
                'author_name' => 'Robert Louis Stevenson',
            ],
            [
                'book_id' => 'robinson',
                'book_title' => 'Robinson Crusoe',
                'author_id' => 'dafoe',
                'author_name' => 'Daniel Dafoe',
            ],
        ];
    }
}