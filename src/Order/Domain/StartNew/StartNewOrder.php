<?php

declare(strict_types=1);

namespace App\Order\Domain\StartNew;

use App\Order\Domain\OrderCartId;
use App\Order\Domain\OrderId;
use App\Shared\Application\Routing\HandleAsStandard;

final readonly class StartNewOrder implements HandleAsStandard
{
    public function __construct(private OrderId $orderId, private OrderCartId $orderCartId)
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getOrderCartId(): OrderCartId
    {
        return $this->orderCartId;
    }
}