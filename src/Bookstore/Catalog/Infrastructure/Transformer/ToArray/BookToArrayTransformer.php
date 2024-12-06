<?php

namespace Bookstore\Catalog\Infrastructure\Transformer\ToArray;

use Bookstore\Catalog\Domain\Model\Book\Book;

class BookToArrayTransformer
{
    public static function transform(Book $book): array
    {
        return [
            'book_id' => $book->bookId()->value(),
            'book_title' => $book->bookTitle()->value(),
            'author' => AuthorToArrayTransformer::transform($book->author()),
        ];
    }
}