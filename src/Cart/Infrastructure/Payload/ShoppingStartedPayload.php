<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Payload;

use App\Cart\Domain\CartId;
use DateTimeImmutable;

trait ShoppingStartedPayload
{
    public function toPayload(): array
    {
        return [
            'id' => $this->cartId->toString(),
            'started_at' => $this->startedAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            CartId::fromString($payload['id']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $payload['started_at'])
        );
    }
}