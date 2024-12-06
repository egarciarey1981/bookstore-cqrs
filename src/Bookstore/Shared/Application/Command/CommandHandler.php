<?php

namespace Bookstore\Shared\Application\Command;

interface CommandHandler
{
    public function handle(Command $command): void;
}
