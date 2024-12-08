<?php

namespace Catalog\Domain\Model\Book;

use Shared\Domain\Exception\ResourceNotFoundException;

class BookNotFoundException extends ResourceNotFoundException
{
    public function __construct(string $message = 'Book not found')
    {
        parent::__construct($message);
    }
}
