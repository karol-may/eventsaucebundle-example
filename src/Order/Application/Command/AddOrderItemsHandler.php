<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Order\Domain\AddOrderItems\AddOrderItems;
use App\Order\Domain\Place\PlaceOrder;
use App\Order\Domain\Order;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRootRepository;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler(
    bus: 'commandBus',
    fromTransport: 'high_priority'
)]
final readonly class AddOrderItemsHandler
{
    /**
     * @param AggregateRootRepository<Order> $orderRepository
     */
    public function __construct(
        #[Target('orderRepository')] private AggregateRootRepository $orderRepository
    )
    {
    }

    public function __invoke(AddOrderItems $command): void
    {
        $preOrder = $this->orderRepository->retrieve($command->getOrderId());
        $preOrder->addOrderItems($command);

        $this->orderRepository->persist($preOrder);
    }
}