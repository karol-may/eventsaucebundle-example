<?php

declare(strict_types=1);

namespace App\Shared;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait ToRamseyUuid4
{
    public function toRamseyUuid(): UuidInterface
    {
        return Uuid::fromString($this->toString());
    }
}