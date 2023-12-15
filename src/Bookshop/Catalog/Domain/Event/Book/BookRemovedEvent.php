<?php

namespace Bookshop\Catalog\Domain\Event\Book;

use Bookshop\Catalog\Domain\Event\DomainEvent;
use Bookshop\Catalog\Domain\Model\Book\Book;
use DateTimeImmutable;

class BookRemovedEvent implements DomainEvent
{
    private DateTimeImmutable $occurredOn;

    public function __construct(private readonly Book $book)
    {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function book(): Book
    {
        return $this->book;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
