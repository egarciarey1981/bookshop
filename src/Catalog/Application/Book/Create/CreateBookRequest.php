<?php

namespace Bookshop\Catalog\Application\Book\Create;

use Bookshop\Catalog\Domain\Book\BookTitle;

class CreateBookRequest
{
    private BookTitle $bookTitle;

    public function __construct(string $title)
    {
        $this->bookTitle = new BookTitle($title);
    }

    public function bookTitle(): BookTitle
    {
        return $this->bookTitle;
    }
}
