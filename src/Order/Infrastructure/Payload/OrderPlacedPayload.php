<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Payload;

use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;
use App\Order\Domain\Purchaser;
use DateTimeImmutable;

trait OrderPlacedPayload
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
            'purchaser' => [
                'first_name' => $this->purchaser->getFirstName(),
                'last_name' => $this->purchaser->getLastName(),
                'address' => $this->purchaser->getAddress(),
            ],
            'placed_at' => $this->placedAt->format('Y-m-d H:i:s'),
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
            Purchaser::create(
                $payload['purchaser']['first_name'],
                $payload['purchaser']['last_name'],
                $payload['purchaser']['address']
            ),
            $orderItems,
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $payload['placed_at'])
        );
    }
}