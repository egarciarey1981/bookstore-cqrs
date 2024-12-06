<?php

namespace Bookstore\Catalog\Infrastructure\Persistence\InMemory\Command;

use Bookstore\Catalog\Domain\Model\Author\Author;
use Bookstore\Catalog\Domain\Model\Author\AuthorCommandRepository;
use Bookstore\Catalog\Infrastructure\Transformer\ToArray\AuthorToArrayTransformer;
use Bookstore\Shared\Domain\Model\Author\AuthorId;
use Bookstore\Shared\Domain\Model\Author\AuthorName;
use Psr\Log\LoggerInterface;

class InMemoryAuthorCommandRepository implements AuthorCommandRepository
{
    private LoggerInterface $logger;
    private array $authors = [];

    /**
     * @param LoggerInterface $logger
     * @param Author[]|null $authors
     */
    public function __construct(
        LoggerInterface $logger,
        array $authors = null
    ) {
        $this->logger = $logger;

        if (null === $authors) {
            $authors = $this->defaultAuthors();
        }

        foreach ($authors as $author) {
            $this->authors[$author->authorId()->value()] = $author;
        }
    }

    public function nextIdentity(): AuthorId
    {
        return new AuthorId(uniqid());
    }

    public function findAll(): array
    {
        return array_values($this->authors);
    }

    public function findById(AuthorId $authorId): ?Author
    {
        return $this->authors[$authorId->value()] ?? null;
    }

    public function save(Author $author): void
    {
        $this->logger->debug(
            'InMemoryAuthorCommandRepository::save',
            AuthorToArrayTransformer::transform($author)
        );
        $this->authors[$author->authorId()->value()] = $author;
    }

    public function delete(Author $author): void
    {
        unset($this->authors[$author->authorId()->value()]);
    }

    /**
     * @return Author[]
     */
    private function defaultAuthors(): array
    {
        $data = [
            [
                'author_id' => 'doyle',
                'author_name' => 'Arthur Conan Doyle',
            ],
            [
                'author_id' => 'verne',
                'author_name' => 'Jules Verne',
            ],
            [
                'author_id' => 'stevenson',
                'author_name' => 'Robert Louis Stevenson',
            ],
            [
                'author_id' => 'dafoe',
                'author_name' => 'Daniel Dafoe',
            ],
        ];

        return array_map(
            fn($author) => new Author(
                new AuthorId($author['author_id']),
                new AuthorName($author['author_name'])
            ),
            $data
        );
    }
}
