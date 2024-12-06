<?php

namespace Shared\Domain\Exception;

use Exception;

class DomainException extends Exception
{
    /**
     * @var array<mixed> $context
     */
    private array $context;

    /**
     * @param array<mixed> $context
     */
    public function __construct(
        string $message = '',
        array $context = [],
    ) {
        parent::__construct($message);
        $this->context = $context;
    }

    /**
     * @return array<mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
