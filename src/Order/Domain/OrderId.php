<?php

declare(strict_types=1);

namespace App\Order\Domain;

use App\Shared\CreateIdWithUuid4;
use App\Shared\ToRamseyUuid4;
use EventSauce\EventSourcing\AggregateRootId;

final readonly class OrderId implements AggregateRootId
{
    use CreateIdWithUuid4;
    use ToRamseyUuid4;

    private function __construct(private string $orderId)
    {
    }

    public static function fromString(string $orderId): static
    {
        return new self($orderId);
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function toString(): string
    {
        return $this->getOrderId();
    }
}