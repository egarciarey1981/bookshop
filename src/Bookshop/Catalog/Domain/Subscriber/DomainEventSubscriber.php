<?php

namespace Bookshop\Catalog\Domain\Subscriber;

use Bookshop\Catalog\Domain\Event\DomainEvent;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $domainEvent): void;
    public function isSubscribedTo(DomainEvent $domainEvent): bool;
}
