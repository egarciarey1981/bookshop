<?php

namespace Bookshop\Catalog\Application\Book\View;

class ViewBookResponse
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
