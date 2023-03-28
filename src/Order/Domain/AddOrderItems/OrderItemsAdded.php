<?php

declare(strict_types=1);

namespace App\Order\Domain\AddOrderItems;

use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;
use App\Order\Infrastructure\Payload\OrderItemsAddedPayload;
use App\Shared\Application\Routing\HandleByMessageOutbox;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class OrderItemsAdded implements SerializablePayload, HandleByMessageOutbox
{
    use OrderItemsAddedPayload;

    /**
     * @param array<OrderItem> $orderItems
     */
    public function __construct(private OrderId $orderId, private array $orderItems)
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }
}