<?php

namespace Bookshop\Catalog\Application\Book\Remove;

class RemoveBookRequest
{
    private string $bookId;

    public function __construct(string $bookId)
    {
        $this->bookId = $bookId;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }
}
