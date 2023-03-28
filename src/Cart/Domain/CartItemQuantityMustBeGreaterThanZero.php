<?php

declare(strict_types=1);

namespace App\Cart\Domain;

use DomainException;

final class CartItemQuantityMustBeGreaterThanZero extends DomainException
{
    public static function create(): self
    {
        return new self('Cart item quantity must be greater than zero.');
    }
}