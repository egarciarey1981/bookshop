<?php

namespace Bookshop\Catalog\Application\Book\Create;

class CreateBookRequest
{
    private string $bookTitle;

    public function __construct(string $bookTitle)
    {
        $this->bookTitle = $bookTitle;
    }

    public function bookTitle(): string
    {
        return $this->bookTitle;
    }
}
