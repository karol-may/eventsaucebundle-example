<?php

declare(strict_types=1);

namespace App\Order\Application\ReadLayer;

use App\Order\Application\ReadLayer\Entity\Order;
use Ramsey\Uuid\UuidInterface;

interface OrderRepository
{
    public function get(UuidInterface $uuid): Order;

    public function add(Order $order): void;

    public function update(): void;
}