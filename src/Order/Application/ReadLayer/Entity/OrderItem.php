<?php

declare(strict_types=1);

namespace App\Order\Application\ReadLayer\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Ramsey\Uuid\UuidInterface;

#[Entity]
class OrderItem
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private int $id;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'integer')]
    private int $price;

    #[Column(type: 'integer')]
    private int $quantity;

    #[ManyToOne(
        targetEntity: Order::class,
        inversedBy: 'items'
    )]
    #[JoinColumn(nullable: false)]
    private Order $order;

    public function __construct(
        string $name,
        int $price,
        int $quantity,
        Order $order
    )
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->order = $order;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}