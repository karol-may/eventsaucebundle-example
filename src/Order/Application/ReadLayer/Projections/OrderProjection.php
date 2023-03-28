<?php

declare(strict_types=1);

namespace App\Order\Application\ReadLayer\Projections;

use Andreo\EventSauce\Messenger\Attribute\AsEventSauceMessageHandler;
use Andreo\EventSauce\Messenger\EventConsumer\InjectedHandleMethodInflector;
use App\Order\Application\ReadLayer\Entity\Order;
use App\Order\Application\ReadLayer\OrderRepository;
use App\Order\Domain\Place\OrderPlaced;
use App\Order\Domain\StartNew\NewOrderStarted;
use EventSauce\EventSourcing\EventConsumption\EventConsumer;
use EventSauce\EventSourcing\EventConsumption\HandleMethodInflector;

final class OrderProjection extends EventConsumer
{
    use InjectedHandleMethodInflector;

    public function __construct(
        private readonly HandleMethodInflector $handleMethodInflector,
        private readonly OrderRepository $orderRepository
    ){}

    #[AsEventSauceMessageHandler(
        bus: 'eventBus',
        fromTransport: 'message_outbox',
    )]
    public function onNewOrderStarted(NewOrderStarted $newOrderStarted): void
    {
        $order = Order::create($newOrderStarted->getOrderId()->toRamseyUuid());

        $this->orderRepository->add($order);
    }

    #[AsEventSauceMessageHandler(
        bus: 'eventBus',
        fromTransport: 'message_outbox',
    )]
    public function onOrderPlaced(OrderPlaced $orderPlaced): void
    {
        $order = $this->orderRepository->get($orderPlaced->getOrderId()->toRamseyUuid());

        $order->setPlacedAt($orderPlaced->getPlacedAt());
        $order->setPurchaser(
            $orderPlaced->getPurchaser()->getFirstName(),
            $orderPlaced->getPurchaser()->getLastName(),
            $orderPlaced->getPurchaser()->getAddress()
        );

        foreach ($orderPlaced->getOrderItems() as $orderItem) {
            $order->addItem(
                $orderItem->getName(),
                $orderItem->getPrice(),
                $orderItem->getQuantity()
            );
        }

        $this->orderRepository->update();
    }
}