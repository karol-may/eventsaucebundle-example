<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(#[Target('queryBus')] readonly MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function query(object $query): mixed
    {
        return $this->messageBus->dispatch($query);
    }
}