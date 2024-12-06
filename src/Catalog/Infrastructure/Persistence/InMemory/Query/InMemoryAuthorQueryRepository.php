<?php

namespace Catalog\Infrastructure\Persistence\InMemory\Query;

use Catalog\Domain\Model\Author\AuthorQueryRepository;
use Psr\Log\LoggerInterface;
use Shared\Domain\Exception\InvalidDataException;

class InMemoryAuthorQueryRepository implements AuthorQueryRepository
{
    private LoggerInterface $logger;

    /**
     * @var array<array<string,mixed>>
     */
    private array $authors = [];

    /**
     * @param array<array<string,mixed>>|null $authors
     */
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

    public function findAll(int $page, int $limit, string $sort, string $order): array
    {
        $authors = array_values($this->authors);

        if (!in_array($sort, array_keys($authors[0]))) {
            throw new InvalidDataException('Invalid sort field', [
                'class' => self::class,
                'page' => $page,
                'limit' => $limit,
                'sort' => $sort,
                'order' => $order,
            ]);
        }

        usort($authors, function ($a, $b) use ($sort, $order) {
            return 'asc' === $order
                ? $a[$sort] <=> $b[$sort]
                : $b[$sort] <=> $a[$sort];
        });

        return array_slice($authors, ($page - 1) * $limit, $limit);
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

    /**
     * @return array<array<string,mixed>>
     */
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
