<?php

declare(strict_types=1);

namespace App\Cart\Application\ProcessManager;

use Andreo\EventSauce\Messenger\Attribute\AsEventSauceMessageHandler;
use Andreo\EventSauce\Messenger\EventConsumer\InjectedHandleMethodInflector;
use Andreo\EventSauceBundle\Attribute\EnableAcl;
use App\Cart\Domain\Checkout\CartAcceptedToCheckout;
use App\Cart\Domain\Checkout\StartAddingCartContentToOrder;
use App\Order\Domain\StartNew\NewOrderStarted;
use App\Shared\Application\Command\CommandBus;
use EventSauce\EventSourcing\EventConsumption\EventConsumer;
use EventSauce\EventSourcing\EventConsumption\HandleMethodInflector;
use EventSauce\EventSourcing\EventDispatcher;

#[EnableAcl]
final class StartAddingCartContentToOrderProcess extends EventConsumer
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
        handles: NewOrderStarted::class
    )]
    public function onCartAcceptedToCheckout(CartAcceptedToCheckout $event): void
    {
        $this->commandBus->execute(
            new StartAddingCartContentToOrder(
                $event->getCartId(),
                $event->getCartOrderId()
            )
        );
    }
}