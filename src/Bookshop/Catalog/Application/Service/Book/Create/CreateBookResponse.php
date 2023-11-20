<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

class CreateBookResponse
{
    private array $book;

    public function __construct(array $book)
    {
        $this->book = $book;
    }

    public function book(): array
    {
        return $this->book;
    }
}
