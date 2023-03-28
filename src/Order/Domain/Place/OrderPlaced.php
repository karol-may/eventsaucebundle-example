<?php

declare(strict_types=1);

namespace App\Order\Domain\Place;

use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;
use App\Order\Domain\Purchaser;
use App\Order\Infrastructure\Payload\OrderPlacedPayload;
use App\Shared\Application\Routing\HandleByMessageOutbox;
use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class OrderPlaced implements SerializablePayload, HandleByMessageOutbox
{
    use OrderPlacedPayload;

    /**
     * @param array<OrderItem> $orderItems
     */
    public function __construct(
        private OrderId $orderId,
        private Purchaser $purchaser,
        private array $orderItems,
        private DateTimeImmutable $placedAt
    )
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getPurchaser(): Purchaser
    {
        return $this->purchaser;
    }

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

    public function getPlacedAt(): DateTimeImmutable
    {
        return $this->placedAt;
    }
}