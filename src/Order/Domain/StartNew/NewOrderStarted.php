<?php

declare(strict_types=1);

namespace App\Order\Domain\StartNew;

use App\Order\Domain\OrderCartId;
use App\Order\Domain\OrderId;
use App\Order\Infrastructure\Payload\NewOrderStartedPayload;
use App\Shared\Application\Routing\HandleByMessageOutbox;
use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class NewOrderStarted implements SerializablePayload, HandleByMessageOutbox
{
    use NewOrderStartedPayload;

    public function __construct(
        private OrderId $orderId,
        private OrderCartId $orderCartId,
        private DateTimeImmutable $startedAt
    )
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getOrderCartId(): OrderCartId
    {
        return $this->orderCartId;
    }

    public function getStartedAt(): DateTimeImmutable
    {
        return $this->startedAt;
    }
}