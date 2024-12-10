<?php

namespace Catalog\Infrastructure\Persistence\InMemory\Query;

use Catalog\Application\Query\Author\AuthorDTO;
use Catalog\Domain\Model\Author\AuthorQueryRepository;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class InMemoryAuthorQueryRepository implements AuthorQueryRepository
{
    private LoggerInterface $logger;

    /**
     * @var array<array<string,mixed>>
     */
    private array $authors = [];

    /**
     * @param AuthorDTO[]|null $authors
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
            $this->authors[$author->authorId()] = [
                'author_id' => $author->authorId(),
                'author_name' => $author->authorName(),
            ];
        }
    }

    public function findAll(int $page, int $limit, string $sort, string $order): array
    {
        $authors = array_values($this->authors);

        if (!in_array($sort, array_keys($authors[0]))) {
            throw new InvalidArgumentException('Invalid sort field');
        }

        usort($authors, function ($a, $b) use ($sort, $order) {
            return 'asc' === $order
                ? $a[$sort] <=> $b[$sort]
                : $b[$sort] <=> $a[$sort];
        });

        $authors = array_slice($authors, ($page - 1) * $limit, $limit);

        return array_map(function ($author) {
            return new AuthorDTO(
                $author['author_id'],
                $author['author_name'],
            );
        }, $authors);
    }

    public function findById(string $authorId): ?AuthorDTO
    {
        if (!isset($this->authors[$authorId])) {
            return null;
        }

        return new AuthorDTO(
            $this->authors[$authorId]['author_id'],
            $this->authors[$authorId]['author_name'],
        );
    }

    public function save(AuthorDTO $author): void
    {
        $this->authors[$author->authorId()] = [
            'author_id' => $author->authorId(),
            'author_name' => $author->authorName(),
        ];
        $this->logger->debug(
            'InMemoryAuthorQueryRepository::save',
            $author->toArray(),
        );
    }

    public function delete(string $authorId): void
    {
        unset($this->authors[$authorId]);
        $this->logger->debug(
            'InMemoryAuthorQueryRepository::delete',
            ['author_id' => $authorId],
        );
    }

    /**
     * @return AuthorDTO[]
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

        return array_map(function ($author) {
            return new AuthorDTO(
                $author['author_id'],
                $author['author_name'],
            );
        }, $data);
    }
}
