<?php

namespace Shared\Application\Command;

interface CommandBus
{
    public function dispatch(Command $command): mixed;
}
