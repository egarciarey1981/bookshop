<?php

namespace Bookshop\Catalog\Application\Book\Update;

use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\Book\BookTitle;

class UpdateBookRequest
{
    private BookId $bookId;
    private BookTitle $bookTitle;

    public function __construct(
        string $id,
        string $title,
    )
    {
        $this->bookId = new BookId($id);
        $this->bookTitle = new BookTitle($title);
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookTitle(): BookTitle
    {
        return $this->bookTitle;
    }
}
