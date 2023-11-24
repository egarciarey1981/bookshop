<?php

namespace Bookshop\Catalog\Domain\Event;

use BadMethodCallException;
use Bookshop\Catalog\Domain\Subscriber\DomainEventSubscriber;

final class DomainEventPublisher
{
    /** @var array<DomainEventSubscriber> $subscribers */
    private array $subscribers;
    private static ?self $instance = null;

    public static function instance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone(): void
    {
        throw new BadMethodCallException('Clone is not supported');
    }

    public function subscribe(DomainEventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(DomainEvent $anEvent): void
    {
        foreach ($this->subscribers as $aSubscriber) {
            if ($aSubscriber->isSubscribedTo($anEvent)) {
                $aSubscriber->handle($anEvent);
            }
        }
    }
}
