<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

use App\Shared\Application\Routing\HandleAsStandard;
use App\Shared\Application\Routing\HandleWithPriority;

interface CommandBus
{
    public function execute(HandleAsStandard|HandleWithPriority $command): void;
}