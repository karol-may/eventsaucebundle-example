<?php

declare(strict_types=1);

namespace App\Order\Domain;

use Andreo\EventSauce\Aggregate\Reconstruction\AggregateRootBehaviourWithAppliesEventsByAttribute;
use Andreo\EventSauce\Aggregate\Reconstruction\EventSourcingHandler;
use App\Order\Domain\AddOrderItems\AddOrderItems;
use App\Order\Domain\AddOrderItems\OrderItemsAdded;
use App\Order\Domain\Place\OrderPlaced;
use App\Order\Domain\Place\PlaceOrder;
use App\Order\Domain\StartNew\NewOrderStarted;use App\Order\Domain\StartNew\StartNewOrder;use DateTimeImmutable;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRoot;

final class Order implements AggregateRoot
{
    use AggregateRootBehaviourWithAppliesEventsByAttribute;

    private OrderCartId $orderCartId;

    private DateTimeImmutable $startedAt;

    private ?DateTimeImmutable $placedAt;

    private ?Purchaser $purchaser;

    /**
     * @var array<OrderItem>
     */
    private array $orderItems;

    private function getOrderId(): OrderId
    {
        return $this->aggregateRootId();
    }

    public static function startOrder(StartNewOrder $command, Clock $clock): self
    {
        $order = new static($command->getOrderId());

        $order->recordThat(
            new NewOrderStarted(
                $order->getOrderId(),
                $command->getOrderCartId(),
                $clock->now(),
            )
        );

        return $order;
    }

    #[EventSourcingHandler]
    private function onOrderStarted(NewOrderStarted $orderStarted): void
    {
        $this->orderCartId = $orderStarted->getOrderCartId();
        $this->startedAt = $orderStarted->getStartedAt();
        $this->purchaser = null;
        $this->placedAt = null;
    }

    public function addOrderItems(AddOrderItems $command): void
    {
        $this->recordThat(
            new OrderItemsAdded(
                $this->getOrderId(),
                $command->getOrderItems(),
            )
        );
    }

    #[EventSourcingHandler]
    private function onOrderItemsAdded(OrderItemsAdded $orderItemsAdded): void
    {
        $this->orderItems = $orderItemsAdded->getOrderItems();
    }

    public function placeOrder(PlaceOrder $command, Clock $clock): void
    {
        $this->recordThat(
            new OrderPlaced(
                $this->getOrderId(),
                $command->getPurchaser(),
                $this->orderItems,
                $clock->now()
            )
        );
    }

    #[EventSourcingHandler]
    private function onOrderPlaced(OrderPlaced $newOrderPlaced): void
    {
        $this->purchaser = $newOrderPlaced->getPurchaser();
        $this->placedAt = $newOrderPlaced->getPlacedAt();
    }
}