<?php

namespace Catalog\Infrastructure\Persistence\InMemory\Query;

use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Psr\Log\LoggerInterface;

class InMemoryAuthorQueryRepository implements AuthorQueryRepository
{
    private LoggerInterface $logger;
    private array $authors = [];

    public function __construct(
        LoggerInterface $logger,
        array $authors = null,
    ) {
        $this->logger = $logger;

        if (null === $authors) {
            $authors = $this->defaultAuthors();
        }

        foreach ($authors as $author) {
            $this->authors[$author['author_id']] = $author;
        }
    }

    public function findAll(int $page, int $limit): array
    {
        return array_values(
            array_slice(
                $this->authors,
                ($page - 1) * $limit,
                $limit,
            )
        );
    }

    public function findById(string $authorId): ?array
    {
        return $this->authors[$authorId] ?? null;
    }

    public function save(array $author): void
    {
        $this->authors[$author['author_id']] = $author;
        $this->logger->debug(
            'InMemoryAuthorQueryRepository::save',
            $author,
        );
    }

    public function delete(string $authorId): void
    {
        unset($this->authors[$authorId]);
    }

    private function defaultAuthors(): array
    {
        return [
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
    }
}
