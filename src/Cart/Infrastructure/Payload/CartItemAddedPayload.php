<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Payload;

use App\Cart\Domain\CartId;
use App\Cart\Domain\CartItem;
use DateTimeImmutable;

trait CartItemAddedPayload
{
    public function toPayload(): array
    {
        return [
            'id' => $this->cartId->toString(),
            'added_at' => $this->addedAt->format('Y-m-d H:i:s'),
            'cart_item' => [
                'name' => $this->cartItem->getName(),
                'price' => $this->cartItem->getPrice(),
                'quantity' => $this->cartItem->getQuantity(),
            ]
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            CartId::fromString($payload['id']),
            CartItem::create(
                $payload['cart_item']['name'],
                $payload['cart_item']['price'],
                $payload['cart_item']['quantity']
            ),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $payload['added_at']),
        );
    }
}