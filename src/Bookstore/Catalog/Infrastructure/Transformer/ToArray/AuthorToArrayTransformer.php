<?php

namespace Bookstore\Catalog\Infrastructure\Transformer\ToArray;

use Bookstore\Catalog\Domain\Model\Author\Author;

class AuthorToArrayTransformer
{
    public static function transform(Author $author): array
    {
        return [
            'author_id' => $author->authorId()->value(),
            'author_name' => $author->authorName()->value(),
        ];
    }
}