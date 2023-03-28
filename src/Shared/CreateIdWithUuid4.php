<?php

declare(strict_types=1);

namespace App\Shared;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait CreateIdWithUuid4
{
    public static function create(): self
    {
        return new self(Uuid::uuid4()->toString());
    }
}