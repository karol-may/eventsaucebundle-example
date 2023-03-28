<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ReadLayer;

use App\Order\Application\ReadLayer\Entity\Order;
use App\Order\Application\ReadLayer\OrderRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

final class DoctrineOrderRepository extends ServiceEntityRepository implements OrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function get(UuidInterface $uuid): Order
    {
        $order = $this->find($uuid);
        assert(null !== $order);

        return $order;
    }

    public function add(Order $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    public function update(): void
    {
        $this->getEntityManager()->flush();
    }
}