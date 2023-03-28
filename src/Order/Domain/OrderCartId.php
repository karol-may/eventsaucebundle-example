<?php

declare(strict_types=1);

namespace App\Order\Domain;

final readonly class OrderCartId
{
    private function __construct(private string $orderCartId)
    {
    }

    public static function create(string $orderCartId): self
    {
        return new self($orderCartId);
    }
    public function toString(): string
    {
        return $this->orderCartId;
    }
}