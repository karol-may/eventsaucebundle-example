<?php

declare(strict_types=1);

namespace App\Cart\Application\Acl\MessageTranslator;

use Andreo\EventSauceBundle\Attribute\AsMessageTranslator;
use App\Cart\Application\ProcessManager\StartAddingCartContentToOrderProcess;
use App\Cart\Domain\CartId;
use App\Cart\Domain\CartOrderId;
use App\Cart\Domain\Checkout\CartAcceptedToCheckout;
use App\Order\Domain\StartNew\NewOrderStarted;
use EventSauce\EventSourcing\AntiCorruptionLayer\MessageTranslator;
use EventSauce\EventSourcing\Message;

#[AsMessageTranslator(owners: StartAddingCartContentToOrderProcess::class,)]
final readonly class CartConnectedToOrderTranslator implements MessageTranslator
{
    public function translateMessage(Message $message): Message
    {
        $payload = $message->payload();
        assert($payload instanceof NewOrderStarted);


        return new Message(
            new CartAcceptedToCheckout(
                CartId::fromString($payload->getOrderCartId()->toString()),
                CartOrderId::create($payload->getOrderId()->toString())
            )
        );
    }
}