<?php

declare(strict_types=1);

namespace App\Order\Domain\Place;

use App\Order\Domain\OrderId;
use App\Order\Domain\Purchaser;
use App\Shared\Application\Routing\HandleAsStandard;

final readonly class PlaceOrder implements HandleAsStandard
{
    public function __construct(private OrderId $orderId, private Purchaser $purchaser)
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getPurchaser(): Purchaser
    {
        return $this->purchaser;
    }
}