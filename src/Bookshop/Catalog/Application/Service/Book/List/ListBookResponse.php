<?php

namespace Bookshop\Catalog\Application\Service\Book\List;

final class ListBookResponse
{
    private int $total;
    /** @var array<array<string,array<array<string,int|string>>|string>> */
    private array $books;

    /** @param array<array<string,array<array<string,int|string>>|string>> $books */
    public function __construct(int $total, array $books)
    {
        $this->total = $total;
        $this->books = $books;
    }

    public function total(): int
    {
        return $this->total;
    }

    /** @return array<array<string,array<array<string,int|string>>|string>> */
    public function books(): array
    {
        return $this->books;
    }
}
