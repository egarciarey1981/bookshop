<?php

namespace Bookshop\Catalog\Application\Book\List;

class ListBooksResponse
{
    private array $books;
    private int $total;

    public function __construct(array $books, int $total)
    {
        $this->books = $books;
        $this->total = $total;
    }

    public function books(): array
    {
        return $this->books;
    }

    public function total(): int
    {
        return $this->total;
    }
}
