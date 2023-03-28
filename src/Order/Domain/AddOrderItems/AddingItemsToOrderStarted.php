<?php

declare(strict_types=1);

namespace App\Order\Domain\AddOrderItems;

use App\Cart\Domain\CartItem;
use App\Order\Domain\OrderCartId;
use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;

final readonly class AddingItemsToOrderStarted
{
    /**
     * @param array<OrderItem> $orderItems
     */
    public function __construct(
        private OrderId $orderId,
        private OrderCartId $orderCartId,
        private array $orderItems
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

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }
}