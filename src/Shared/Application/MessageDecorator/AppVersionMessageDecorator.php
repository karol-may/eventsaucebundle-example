<?php

declare(strict_types=1);

namespace App\Shared\Application\MessageDecorator;

use Andreo\EventSauceBundle\Attribute\AsMessageDecorator;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;

#[AsMessageDecorator]
final readonly class AppVersionMessageDecorator implements MessageDecorator
{
    public function __construct(private int $appVersion = 1)
    {
    }

    public function decorate(Message $message): Message
    {
        return $message->withHeader('__app_ver', $this->appVersion);
    }
}