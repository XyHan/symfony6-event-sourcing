<?php

declare(strict_types=1);

namespace App\Shared\Adapter;

use Broadway\CommandHandling\CommandBus as BroadwayCommandBus;
use Broadway\CommandHandling\CommandHandler;

readonly class CommandBus implements CommandBusInterface
{
    public function __construct(private BroadwayCommandBus $commandBus) {}

    public function dispatch($command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function subscribe(CommandHandler $handler): void
    {
        $this->commandBus->subscribe($handler);
    }
}
