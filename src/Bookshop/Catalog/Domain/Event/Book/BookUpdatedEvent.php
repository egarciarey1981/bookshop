<?php

namespace Bookshop\Catalog\Domain\Event\Book;

use Bookshop\Catalog\Domain\Event\DomainEvent;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use DateTimeImmutable;

class BookUpdatedEvent implements DomainEvent
{
    private DateTimeImmutable $occurredOn;

    public function __construct(private readonly BookId $bookId)
    {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
