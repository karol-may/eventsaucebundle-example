<?php

declare(strict_types=1);

namespace App\Cart\Domain\Snapshot;

use Andreo\EventSauce\Snapshotting\Versioned\VersionedSnapshotState;
use App\Cart\Domain\CartItem;
use App\Cart\Infrastructure\Payload\CartSnapshotPayload;
use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Stringable;

final readonly class CartSnapshot implements VersionedSnapshotState, SerializablePayload
{
    use CartSnapshotPayload;

    private DateTimeImmutable $shoppingStartedAt;

    /**
     * @var array<CartItem>
     */
    private array $cartItems;

    /**
     * @param array<CartItem> $cartItems
     */
    public function __construct(
        DateTimeImmutable $shoppingStartedAt,
        array $cartItems
    )
    {
        $this->shoppingStartedAt = $shoppingStartedAt;
        $this->cartItems = $cartItems;
    }

    public static function getSnapshotVersion(): int|string|Stringable
    {
        return 1;
    }

    public function getShoppingStartedAt(): DateTimeImmutable
    {
        return $this->shoppingStartedAt;
    }

    public function getCartItems(): array
    {
        return $this->cartItems;
    }
}