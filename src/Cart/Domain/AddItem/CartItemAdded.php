<?php

declare(strict_types=1);

namespace App\Cart\Domain\AddItem;

use App\Cart\Domain\CartId;
use App\Cart\Domain\CartItem;
use App\Cart\Infrastructure\Payload\CartItemAddedPayload;
use App\Shared\Application\Routing\HandleByMessageOutbox;
use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class CartItemAdded implements SerializablePayload, HandleByMessageOutbox
{
    use CartItemAddedPayload;

    public function __construct(
        private CartId $cartId,
        private CartItem $cartItem,
        private DateTimeImmutable $addedAt
    )
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getCartItem(): CartItem
    {
        return $this->cartItem;
    }

    public function getAddedAt(): DateTimeImmutable
    {
        return $this->addedAt;
    }
}