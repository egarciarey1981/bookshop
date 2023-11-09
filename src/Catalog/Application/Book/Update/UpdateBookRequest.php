<?php

namespace Bookshop\Catalog\Application\Book\Update;

class UpdateBookRequest
{
    private string $bookId;
    private string $bookTitle;

    public function __construct(
        string $bookId,
        string $bookTitle,
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }

    public function bookTitle(): string
    {
        return $this->bookTitle;
    }
}
