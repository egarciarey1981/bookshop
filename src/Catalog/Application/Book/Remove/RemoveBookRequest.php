<?php

namespace Bookshop\Catalog\Application\Book\Remove;

use Bookshop\Catalog\Domain\Book\BookId;

class RemoveBookRequest
{
    private BookId $bookId;

    public function __construct(string $id)
    {
        $this->bookId = new BookId($id);
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }
}
