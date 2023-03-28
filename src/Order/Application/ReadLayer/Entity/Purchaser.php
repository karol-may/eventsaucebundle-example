<?php

declare(strict_types=1);

namespace App\Order\Application\ReadLayer\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Purchaser
{
    #[Column(type: 'string', nullable: true)]
    private ?string $firstName;

    #[Column(type: 'string', nullable: true)]
    private ?string $lastName;

    #[Column(type: 'string', nullable: true)]
    private ?string $address;

    public function __construct(string $firstName, string $lastName, string $address)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }
}