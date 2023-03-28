<?php

declare(strict_types=1);

namespace App\Cart\Domain;

use DomainException;

final class CartPriceMustBeGreaterThanZero extends DomainException
{
    public static function create(): self
    {
        return new self('Cart item price must be greater than zero.');
    }
}