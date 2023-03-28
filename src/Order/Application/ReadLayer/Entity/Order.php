<?php

declare(strict_types=1);

namespace App\Order\Application\ReadLayer\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity]
#[Table(name: "`order`")]
class Order
{
    #[Id]
    #[Column(type: 'uuid_binary', unique: true)]
    #[GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $placedAt;

    #[Embedded(class: Purchaser::class, columnPrefix: 'purchaser_')]
    private ?Purchaser $purchaser;

    #[OneToMany(
        mappedBy: '`order`',
        targetEntity: OrderItem::class,
        cascade: ['persist'],
        fetch: 'EXTRA_LAZY',
        orphanRemoval: true
    )]
    private Collection $items;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
        $this->placedAt = null;
        $this->purchaser = null;
        $this->items = new ArrayCollection();
    }

    public static function create(UuidInterface $id): self
    {
        return new self($id);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getPlacedAt(): ?DateTimeImmutable
    {
        return $this->placedAt;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getPurchaser(): ?Purchaser
    {
        return $this->purchaser;
    }

    public function setPlacedAt(DateTimeImmutable $placedAt): Order
    {
        $this->placedAt = $placedAt;

        return $this;
    }

    public function setPurchaser(string $firstName, string $lastName, string $address): self
    {
        $this->purchaser = new Purchaser($firstName, $lastName, $address);

        return $this;
    }

    public function addItem(string $name, int $price, int $quantity): void
    {
        $this->items->add(
            new OrderItem($name, $price, $quantity, $this)
        );
    }
}