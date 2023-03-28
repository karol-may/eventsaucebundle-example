<?php

declare(strict_types=1);

namespace App\Cart\Domain\AddItem;

use App\Cart\Domain\CartId;
use App\Cart\Domain\CartItem;
use App\Shared\Application\Routing\HandleWithPriority;

final readonly class AddCartItem implements HandleWithPriority
{
    public function __construct(private CartId $cartId, private CartItem $cartItem)
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
}