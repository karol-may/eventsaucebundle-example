<?php

declare(strict_types=1);

namespace App\Cart\Application\Command;

use App\Cart\Domain\Cart;
use App\Cart\Domain\StartShopping\StartShopping;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\Snapshotting\AggregateRootRepositoryWithSnapshotting;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(
    bus: 'commandBus',
    fromTransport: 'normal_priority'
)]
final readonly class StartShoppingHandler
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

    public function __invoke(StartShopping $command): void
    {
        $cart = Cart::startShopping($command->getCartId(), $this->clock);
        $this->cartRepository->persist($cart);
    }
}