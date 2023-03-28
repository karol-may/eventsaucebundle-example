<?php

declare(strict_types=1);

namespace App\Cart\Domain\Checkout;

use App\Cart\Domain\CartId;
use App\Cart\Domain\CartItem;
use App\Cart\Domain\CartOrderId;
use App\Cart\Infrastructure\Payload\AddingCartContentToOrderStartedPayload;
use App\Shared\Application\Routing\HandleByMessageOutbox;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class AddingCartContentToOrderStarted implements SerializablePayload, HandleByMessageOutbox
{
    use AddingCartContentToOrderStartedPayload;

    /**
     * @param array<CartItem> $cartItems
     */
    public function __construct(
        private CartId $cartId,
        private CartOrderId $cartOrderId,
        private array $cartItems
    )
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    public function getCartOrderId(): CartOrderId
    {
        return $this->cartOrderId;
    }
}