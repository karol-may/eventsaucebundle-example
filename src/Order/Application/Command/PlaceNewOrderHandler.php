<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Order\Domain\Place\PlaceOrder;
use App\Order\Domain\Order;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRootRepository;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler(
    bus: 'commandBus',
    fromTransport: 'normal_priority'
)]
final readonly class PlaceNewOrderHandler
{
    /**
     * @param AggregateRootRepository<Order> $orderRepository
     */
    public function __construct(
        #[Target('orderRepository')] private AggregateRootRepository $orderRepository,
        private Clock $clock
    )
    {
    }

    public function __invoke(PlaceOrder $command): void
    {
        $preOrder = $this->orderRepository->retrieve($command->getOrderId());
        $preOrder->placeOrder($command, $this->clock);

        $this->orderRepository->persist($preOrder);
    }
}