<?php

declare(strict_types=1);

namespace App\Cart\Domain;

use DomainException;

final class CanNotAddContentIfCartIsEmpty extends DomainException
{
    public static function create(): self
    {
        return new self('Can not go to checkout if cart is empty.');
    }
}