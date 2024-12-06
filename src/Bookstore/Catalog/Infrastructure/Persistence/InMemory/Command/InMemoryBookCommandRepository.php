<?php

namespace Bookstore\Catalog\Infrastructure\Persistence\InMemory\Command;

use Bookstore\Catalog\Domain\Model\Author\Author;
use Bookstore\Catalog\Domain\Model\Book\Book;
use Bookstore\Catalog\Domain\Model\Book\BookCommandRepository;
use Bookstore\Catalog\Infrastructure\Transformer\ToArray\BookToArrayTransformer;
use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Author\AuthorName;
use Bookstore\Shared\Domain\Model\Book\BookId;
use Bookstore\Shared\Domain\Model\Book\BookTitle;
use Psr\Log\LoggerInterface;

class InMemoryBookCommandRepository implements BookCommandRepository
{
    private LoggerInterface $logger;
    private array $books = [];

    /**
     * @param Book[]|null $books
     */
    public function __construct(
        LoggerInterface $logger,
        array $books = null
    ) {
        $this->logger = $logger;

        if (null === $books) {
            $books = $this->defaultBooks();
        }

        foreach ($books as $book) {
            $this->books[$book->bookId()->value()] = $book;
        }
    }

    public function nextIdentity(): BookId
    {
        return new BookId(uniqid());
    }

    public function findAll(): array
    {
        return array_values($this->books);
    }

    public function findById(BookId $bookId): ?Book
    {
        return $this->books[$bookId->value()] ?? null;
    }

    public function save(Book $book): void
    {
        $this->books[$book->bookId()->value()] = $book;
        $this->logger->debug(
            'InMemoryBookCommandRepository::save',
            BookToArrayTransformer::transform($book),
        );
    }

    public function delete(Book $book): void
    {
        unset($this->books[$book->bookId()->value()]);
    }

    public function defaultBooks(): array
    {
        $data = [
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

        return array_map(
            fn(array $book) => new Book(
                new BookId($book['book_id']),
                new BookTitle($book['book_title']),
                new Author(
                    new AuthorId($book['author_id']),
                    new AuthorName($book['author_name']),
                ),
            ),
            $data
        );
    }
}
