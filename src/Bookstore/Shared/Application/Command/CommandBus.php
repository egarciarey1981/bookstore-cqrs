<?php

namespace Bookstore\Shared\Application\Command;

interface BusCommand
{
    public function dispatch(Command $command): void;
}
