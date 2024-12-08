<?php

namespace Catalog\Domain\Model\Author;

use Shared\Domain\Exception\ResourceNotFoundException;

class AuthorNotFoundException extends ResourceNotFoundException
{
    public function __construct(string $message = 'Author not found.')
    {
        parent::__construct($message);
    }
}
