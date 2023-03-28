<?php

declare(strict_types=1);

namespace App\Cart\Domain\Checkout;

use App\Cart\Domain\CartId;
use App\Cart\Domain\CartOrderId;
use App\Shared\Application\Routing\HandleAsStandard;

final readonly class StartAddingCartContentToOrder implements HandleAsStandard
{
    public function __construct(private CartId $cartId, private CartOrderId $cartOrderId)
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getCartOrderId(): CartOrderId
    {
        return $this->cartOrderId;
    }
}