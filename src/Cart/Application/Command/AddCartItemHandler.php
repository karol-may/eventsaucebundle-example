<?php

declare(strict_types=1);

namespace App\Cart\Application\Command;

use App\Cart\Domain\AddItem\AddCartItem;
use App\Cart\Domain\Cart;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\Snapshotting\AggregateRootRepositoryWithSnapshotting;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(
    bus: 'commandBus',
    fromTransport: 'high_priority'
)]
final readonly class AddCartItemHandler
{
    /**
     * @param AggregateRootRepositoryWithSnapshotting<Cart> $cartRepository
     */
    public function __construct(
        #[Target('cartRepository')] private AggregateRootRepositoryWithSnapshotting $cartRepository,
        private Clock $clock
    )
    {
    }

    public function __invoke(AddCartItem $command): void
    {
        $cart = $this->cartRepository->retrieveFromSnapshot($command->getCartId());

        $cart->addCartItem($command, $this->clock);

        $this->cartRepository->persist($cart);
        $this->cartRepository->storeSnapshot($cart);
    }
}