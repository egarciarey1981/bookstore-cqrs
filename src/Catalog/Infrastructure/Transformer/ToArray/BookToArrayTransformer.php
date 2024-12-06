<?php

namespace Catalog\Infrastructure\Transformer\ToArray;

use Catalog\Domain\Model\Book\Book;

class BookToArrayTransformer
{
    /**
     * @return array<string,mixed>
     */
    public static function transform(Book $book): array
    {
        return [
            'book_id' => $book->bookId()->value(),
            'book_title' => $book->bookTitle()->value(),
            'author' => AuthorToArrayTransformer::transform($book->author()),
        ];
    }
}
