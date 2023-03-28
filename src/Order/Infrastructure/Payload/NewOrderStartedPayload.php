<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Payload;

use App\Order\Domain\OrderCartId;
use App\Order\Domain\OrderId;
use DateTimeImmutable;

trait NewOrderStartedPayload
{
    public function toPayload(): array
    {
        return [
            'order_id' => $this->getOrderId()->toString(),
            'order_cart_id' => $this->getOrderCartId()->toString(),
            'started_at' => $this->getStartedAt()->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            OrderId::fromString($payload['order_id']),
            OrderCartId::create($payload['order_cart_id']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $payload['started_at'])
        );
    }
}