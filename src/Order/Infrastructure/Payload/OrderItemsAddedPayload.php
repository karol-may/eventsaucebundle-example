<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Payload;

use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;

trait OrderItemsAddedPayload
{
    public function toPayload(): array
    {
        $orderItems = [];
        foreach ($this->orderItems as $cartItem) {
            $orderItems[] = [
                'name' => $cartItem->getName(),
                'price' => $cartItem->getPrice(),
                'quantity' => $cartItem->getQuantity(),
            ];
        }

        return [
            'id' => $this->orderId->toString(),
            'order_items' => $orderItems,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        $orderItems = [];
        foreach ($payload['order_items'] as $orderItemPayload) {
            $orderItems[] = OrderItem::create(
                $orderItemPayload['name'],
                $orderItemPayload['price'],
                $orderItemPayload['quantity']
            );
        }

        return new self(
            OrderId::fromString($payload['id']),
            $orderItems,
        );
    }
}