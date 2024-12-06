<?php

namespace Catalog\Domain\Model\Author;

use Shared\Domain\Exception\ResourceNotFoundException;

class AuthorNotFoundException extends ResourceNotFoundException
{
    /**
     * @param array<mixed> $context
     */
    public function __construct(
        string $message = 'Author not found.',
        array $context = [],
    ) {
        parent::__construct($message, $context);
    }
}
