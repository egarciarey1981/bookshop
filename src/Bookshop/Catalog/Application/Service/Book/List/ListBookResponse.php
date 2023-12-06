<?php

namespace Bookshop\Catalog\Application\Service\Book\List;

class ListBookResponse
{
    private int $total;
    private array $books;

    public function __construct(int $total, array $books)
    {
        $this->total = $total;
        $this->books = $books;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function books(): array
    {
        return $this->books;
    }
}
