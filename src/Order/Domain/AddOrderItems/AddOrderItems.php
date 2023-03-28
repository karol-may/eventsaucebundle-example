<?php

declare(strict_types=1);

namespace App\Order\Domain\AddOrderItems;

use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;
use App\Shared\Application\Routing\HandleWithPriority;

final readonly class AddOrderItems implements HandleWithPriority
{
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