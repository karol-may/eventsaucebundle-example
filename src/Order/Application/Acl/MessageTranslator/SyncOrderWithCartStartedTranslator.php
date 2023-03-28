<?php

declare(strict_types=1);

namespace App\Order\Application\Acl\MessageTranslator;

use Andreo\EventSauceBundle\Attribute\AsMessageTranslator;
use App\Cart\Domain\Checkout\AddingCartContentToOrderStarted;
use App\Order\Application\ProcessManager\AddOrderItemsToOrderProcess;
use App\Order\Domain\OrderCartId;
use App\Order\Domain\OrderId;
use App\Order\Domain\OrderItem;
use App\Order\Domain\AddOrderItems\AddingItemsToOrderStarted;
use EventSauce\EventSourcing\AntiCorruptionLayer\MessageTranslator;
use EventSauce\EventSourcing\Message;

#[AsMessageTranslator(owners: AddOrderItemsToOrderProcess::class,)]
final readonly class SyncOrderWithCartStartedTranslator implements MessageTranslator
{
    public function translateMessage(Message $message): Message
    {
        $payload = $message->payload();
        assert($payload instanceof AddingCartContentToOrderStarted);

        $orderItems = [];
        foreach ($payload->getCartItems() as $cartItem) {
            $orderItems[] = OrderItem::create(
                $cartItem->getName(),
                $cartItem->getPrice(),
                $cartItem->getQuantity()
            );
        }

        return new Message(
            new AddingItemsToOrderStarted(
                OrderId::fromString($payload->getCartOrderId()->toString()),
                OrderCartId::create($payload->getCartId()->toString()),
                $orderItems
            )
        );
    }
}