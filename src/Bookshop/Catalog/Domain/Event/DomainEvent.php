<?php

namespace Bookshop\Catalog\Domain\Event;

use DateTimeImmutable;

interface DomainEvent
{
    public function occurredOn(): DateTimeImmutable;
}
