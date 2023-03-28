<?php

declare(strict_types=1);

namespace App\Cart\Domain;

final readonly class CartItem
{
    private function __construct(private string $name, private int $price, private int $quantity)
    {
    }

    public static function create(string $name, int $price, int $quantity): self
    {
        return new self($name, $price, $quantity);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}