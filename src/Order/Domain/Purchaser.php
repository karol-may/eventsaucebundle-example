<?php

declare(strict_types=1);

namespace App\Order\Domain;

final readonly class Purchaser
{
    private function __construct(
        private string $firstName,
        private string $lastName,
        private string $address
    )
    {
    }

    public static function create(string $firstName, string $lastName, string $address): self
    {
        return new self($firstName, $lastName, $address);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}