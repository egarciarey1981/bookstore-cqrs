<?php

namespace Catalog\Infrastructure\Persistence\InMemory\Command;

use Catalog\Domain\Model\Author\Author;
use Catalog\Domain\Model\Author\AuthorCommandRepository;
use Catalog\Infrastructure\Transformer\ToArray\AuthorToArrayTransformer;
use Shared\Domain\Model\Author\AuthorId;
use Shared\Domain\Model\Author\AuthorName;
use Psr\Log\LoggerInterface;

class InMemoryAuthorCommandRepository implements AuthorCommandRepository
{
    private LoggerInterface $logger;

    /**
     * @var Author[]
     */
    private array $authors = [];

    /**
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
        $this->authors[$author->authorId()->value()] = $author;
        $this->logger->debug(
            'InMemoryAuthorCommandRepository::save',
            AuthorToArrayTransformer::transform($author),
        );
    }

    public function delete(AuthorId $authorId): void
    {
        unset($this->authors[$authorId->value()]);
        $this->logger->debug(
            'InMemoryAuthorCommandRepository::delete',
            ['author_id' => $authorId->value()],
        );
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
