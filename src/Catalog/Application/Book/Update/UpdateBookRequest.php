<?php

namespace Bookshop\Catalog\Application\Book\Update;

use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\Book\BookTitle;

class UpdateBookRequest
{
    private Book $book;

    public function __construct(
        string $id,
        string $title,
    )
    {
        $this->book = new Book(
            new BookId($id),
            new BookTitle($title),
        );
    }

    public function book(): Book
    {
        return $this->book;
    }
}
