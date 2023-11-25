<?php

namespace Bookshop\Catalog\Application\Service\Book\View;

final class ViewBookResponse
{
    /** @var array<string,array<array<string,int|string>>|string> */
    private array $book;

    /** @param array<string,array<array<string,int|string>>|string> $book */
    public function __construct(array $book)
    {
        $this->book = $book;
    }

    /** @return array<string,array<array<string,int|string>>|string> */
    public function book(): array
    {
        return $this->book;
    }
}
