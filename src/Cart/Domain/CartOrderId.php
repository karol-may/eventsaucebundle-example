<?php

declare(strict_types=1);

namespace App\Cart\Domain;

final readonly class CartOrderId
{
    private function __construct(private string $cartOrderId)
    {
    }

    public static function create(string $cartOrderId): self
    {
        return new self($cartOrderId);
    }

    public function toString(): string
    {
        return $this->cartOrderId;
    }
}