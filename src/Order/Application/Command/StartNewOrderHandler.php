<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Order\Domain\Order;
use App\Order\Domain\StartNew\StartNewOrder;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRootRepository;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler(
    bus: 'commandBus',
    fromTransport: 'normal_priority'
)]
final readonly class StartNewOrderHandler
{
    public function __construct(
        #[Target('orderRepository')] private AggregateRootRepository $orderRepository,
        private Clock $clock
    )
    {
    }

    public function __invoke(StartNewOrder $command): void
    {
        $order = Order::startOrder($command, $this->clock);

        $this->orderRepository->persist($order);
    }
}