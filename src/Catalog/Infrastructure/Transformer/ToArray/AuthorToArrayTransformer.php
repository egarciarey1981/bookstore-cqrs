<?php

namespace Catalog\Infrastructure\Transformer\ToArray;

use Catalog\Domain\Model\Author\Author;

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
