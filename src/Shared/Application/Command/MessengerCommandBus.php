<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

use App\Shared\Application\Routing\HandleAsStandard;
use App\Shared\Application\Routing\HandleWithPriority;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerCommandBus implements CommandBus
{
    public function __construct(#[Target('commandBus')] private MessageBusInterface $commandBus)
    {
    }

    public function execute(HandleAsStandard|HandleWithPriority $command): void
    {
        $this->commandBus->dispatch($command);
    }
}