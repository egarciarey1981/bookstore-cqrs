<?php

namespace Shared\Application\Command;

interface CommandHandler
{
    public function handle(Command $command): mixed;
}
