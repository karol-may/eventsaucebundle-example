<?php

declare(strict_types=1);

namespace App\Order\Application\ProcessManager;

use Andreo\EventSauce\Messenger\Attribute\AsEventSauceMessageHandler;
use Andreo\EventSauce\Messenger\EventConsumer\InjectedHandleMethodInflector;
use Andreo\EventSauceBundle\Attribute\EnableAcl;
use App\Cart\Domain\Checkout\AddingCartContentToOrderStarted;
use App\Order\Domain\AddOrderItems\AddOrderItems;
use App\Order\Domain\AddOrderItems\AddingItemsToOrderStarted;
use App\Shared\Application\Command\CommandBus;
use EventSauce\EventSourcing\EventConsumption\EventConsumer;
use EventSauce\EventSourcing\EventConsumption\HandleMethodInflector;
use EventSauce\EventSourcing\EventDispatcher;

#[EnableAcl]
final class AddOrderItemsToOrderProcess extends EventConsumer
{
    use InjectedHandleMethodInflector;

    public function __construct(
        private readonly HandleMethodInflector $handleMethodInflector,
        private readonly CommandBus $commandBus,
        private readonly EventDispatcher $eventDispatcher
    ){}

    #[AsEventSauceMessageHandler(
        bus: 'eventBus',
        fromTransport: 'message_outbox',
        handles: AddingCartContentToOrderStarted::class
    )]
    public function onAddingOrderItemsToOrderStarted(AddingItemsToOrderStarted $event): void
    {
        $this->commandBus->execute(
            new AddOrderItems($event->getOrderId(), $event->getOrderItems())
        );
    }
}