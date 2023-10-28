<?php

namespace Bookshop\Catalog\Application\Book\Delete;

use Bookshop\Catalog\Domain\Book\BookId;

class DeleteBookRequest
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
