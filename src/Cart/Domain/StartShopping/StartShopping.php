<?php

declare(strict_types=1);

namespace App\Cart\Domain\StartShopping;

use App\Cart\Domain\CartId;
use App\Shared\Application\Routing\HandleAsStandard;

final readonly class StartShopping implements HandleAsStandard
{
    public function __construct(private CartId $cartId)
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }
}