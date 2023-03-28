<?php

declare(strict_types=1);

namespace App\Cart\Domain\StartShopping;

use App\Cart\Domain\CartId;
use App\Cart\Infrastructure\Payload\ShoppingStartedPayload;
use App\Shared\Application\Routing\HandleByMessageOutbox;
use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class ShoppingStarted implements SerializablePayload, HandleByMessageOutbox
{
    use ShoppingStartedPayload;

    public function __construct(
        private CartId $cartId,
        private DateTimeImmutable $startedAt
    )
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getStartedAt(): DateTimeImmutable
    {
        return $this->startedAt;
    }
}