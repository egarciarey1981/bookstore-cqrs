<?php

namespace Bookstore\Catalog\Domain\Model\Author;

use Bookstore\Shared\Domain\Exception\ResourceNotFoundException;

class AuthorNotFoundException extends ResourceNotFoundException
{
    public function __construct(
        string $message = 'Author not found.',
        array $context = [],
    ) {
        parent::__construct($message, $context);
    }
}
