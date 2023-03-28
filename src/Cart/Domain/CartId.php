<?php

declare(strict_types=1);

namespace App\Cart\Domain;

use App\Shared\CreateIdWithUuid4;
use EventSauce\EventSourcing\AggregateRootId;

final readonly class CartId implements AggregateRootId
{
    use CreateIdWithUuid4;

    private function __construct(private string $cartId)
    {
    }

    public static function fromString(string $cartId): static
    {
        return new self($cartId);
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function toString(): string
    {
        return $this->getCartId();
    }

}