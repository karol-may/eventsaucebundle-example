<?php

declare(strict_types=1);

namespace App\Cart\Domain;

use Andreo\EventSauce\Aggregate\Reconstruction\AggregateRootBehaviourWithAppliesEventsByAttribute;
use Andreo\EventSauce\Aggregate\Reconstruction\EventSourcingHandler;
use Andreo\EventSauce\Snapshotting\Aggregate\VersionedSnapshottingBehaviour;
use App\Cart\Domain\AddItem\AddCartItem;
use App\Cart\Domain\AddItem\CartItemAdded;
use App\Cart\Domain\StartShopping\ShoppingStarted;
use App\Cart\Domain\Snapshot\CartSnapshot;
use App\Cart\Domain\Checkout\StartAddingCartContentToOrder;
use App\Cart\Domain\Checkout\AddingCartContentToOrderStarted;
use DateTimeImmutable;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Snapshotting\AggregateRootWithSnapshotting;

final class Cart implements AggregateRootWithSnapshotting
{
    use AggregateRootBehaviourWithAppliesEventsByAttribute;
    use VersionedSnapshottingBehaviour;

    private DateTimeImmutable $shoppingStartedAt;

    /**
     * @var array<CartItem>
     */
    private array $cartItems = [];

    private function getCartId(): CartId
    {
        return $this->aggregateRootId();
    }

    public static function startShopping(CartId $cartId, Clock $clock): self
    {
        $cart = new static($cartId);

        $cart->recordThat(
            new ShoppingStarted(
                $cart->getCartId(),
                $clock->now()
            )
        );

        return $cart;
    }


    #[EventSourcingHandler]
    private function onShoppingStarted(ShoppingStarted $shoppingStarted): void
    {
        $this->cartItems = [];
        $this->shoppingStartedAt = $shoppingStarted->getStartedAt();
    }

    public function addCartItem(AddCartItem $command, Clock $clock): void
    {
        if ($command->getCartItem()->getQuantity() <= 0) {
            throw CartItemQuantityMustBeGreaterThanZero::create();
        }
        if ($command->getCartItem()->getPrice() <= 0) {
            throw CartPriceMustBeGreaterThanZero::create();
        }

        $this->recordThat(
            new CartItemAdded(
                $this->getCartId(),
                $command->getCartItem(),
                $clock->now()
            )
        );
    }

    #[EventSourcingHandler]
    public function onCartItemAdded(CartItemAdded $cartItemAdded): void
    {
        $this->cartItems[] = $cartItemAdded->getCartItem();
    }

    public function startAddingContent(StartAddingCartContentToOrder $command): void
    {
        if ($this->isCartEmpty()) {
            throw CanNotAddContentIfCartIsEmpty::create();
        }

        $this->recordThat(new AddingCartContentToOrderStarted(
            $this->getCartId(),
            $command->getCartOrderId(),
            $this->getCartItems()
        ));
    }

    protected function createSnapshotState(): CartSnapshot
    {
        return new CartSnapshot(
            $this->shoppingStartedAt,
            $this->cartItems,
        );
    }

    protected static function reconstituteFromSnapshotState(AggregateRootId $id, $state): AggregateRootWithSnapshotting
    {
        assert($state instanceof CartSnapshot);

        $cart = new self($id);

        $cart->shoppingStartedAt = $state->getShoppingStartedAt();
        $cart->cartItems = $state->getCartItems();

        return $cart;
    }

    private function isCartEmpty(): bool
    {
        return empty($this->getCartItems());
    }

    private function getShoppingStartedAt(): DateTimeImmutable
    {
        return $this->shoppingStartedAt;
    }

    private function getCartItems(): array
    {
        return $this->cartItems;
    }
}