<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Payload;

use App\Cart\Domain\CartItem;
use DateTimeImmutable;

trait CartSnapshotPayload
{
    public function toPayload(): array
    {
        $cartItems = [];
        foreach ($this->cartItems as $cartItem) {
            $cartItems[] = [
                'name' => $cartItem->getName(),
                'price' => $cartItem->getPrice(),
                'quantity' => $cartItem->getQuantity(),
            ];
        }

        return [
            'shopping_started_at' => $this->shoppingStartedAt->format('Y-m-d H:i:s'),
            'cart_items' => $cartItems,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        $cartItems = [];
        foreach ($payload['cart_items'] as $cartItemPayload) {
            $cartItems[] = CartItem::create(
                $cartItemPayload['name'],
                $cartItemPayload['price'],
                $cartItemPayload['quantity']
            );
        }

        return new self(
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $payload['shopping_started_at']),
            $cartItems,
        );
    }
}