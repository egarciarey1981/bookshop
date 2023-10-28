<?php

namespace Bookshop\Catalog\Application\Book\View;

use Bookshop\Catalog\Domain\Book\Book;

class ViewBookResponse
{
    private array $book = [];

    public function __construct(Book $book)
    {
        $this->book = [
            'id' => $book->id()->value(),
            'title' => $book->title()->value(),
        ];
    }

    public function book(): array
    {
        return $this->book;
    }
}
