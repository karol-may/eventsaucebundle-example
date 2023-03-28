<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Payload;

use App\Cart\Domain\CartId;
use App\Cart\Domain\CartItem;
use App\Cart\Domain\CartOrderId;

trait AddingCartContentToOrderStartedPayload
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
            'cart_id' => $this->cartId->toString(),
            'cart_order_id' => $this->cartOrderId->toString(),
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
            CartId::fromString($payload['cart_id']),
            CartOrderId::create($payload['cart_order_id']),
            $cartItems,
        );
    }
}