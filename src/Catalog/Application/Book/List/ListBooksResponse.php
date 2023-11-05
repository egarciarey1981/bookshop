<?php

namespace Bookshop\Catalog\Application\Book\List;

class ListBooksResponse
{
    private array $books;

    public function __construct(array $books)
    {
        $this->books = $books;
    }

    public function books(): array
    {
        return $this->books;
    }
}